<?php

use App\Models\Application;
use App\Models\Membership;
use App\Models\StudentProfile;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    config(['database.default' => 'mongodb', 'database.connections.mongodb.dsn' => env('TEST_MONGODB_URI', 'mongodb://127.0.0.1:27017'), 'database.connections.mongodb.database' => 'nextstep_admin_test']);
    DB::purge('mongodb');
    DB::connection('mongodb')->getDatabase()->drop();
    $this->withoutVite();
    $this->admin = User::factory()->create(['first_name' => 'Administradora', 'role' => 'admin']);
});

afterEach(function () {
    DB::connection('mongodb')->getDatabase()->drop();
});

function planFields(array $overrides = []): array
{
    return array_merge(['code' => 'basic', 'name' => 'Basic', 'price' => 150, 'vacancy_limit' => 8, 'priority' => 1, 'benefits' => ['Publicar vacantes'], 'active' => true], $overrides);
}

test('private routes reject guests and other roles', function () {
    $this->getJson('/api/admin/students')->assertUnauthorized();
    $this->postJson('/api/users', [])->assertUnauthorized();
    foreach (['student', 'company'] as $role) {
        $user = User::factory()->create(['role' => $role]);
        $this->actingAs($user, 'web')->getJson('/api/admin/students')->assertForbidden();
        $this->postJson('/api/admin/memberships', planFields())->assertForbidden();
        $this->get('/admin/payments')->assertForbidden();
    }
});

test('admin login returns a session identity without password or bearer token', function () {
    $this->postJson('/login', ['email' => $this->admin->email, 'password' => 'password'])->assertOk()->assertJsonPath('user.role', 'admin')->assertJsonStructure(['csrf_token'])->assertJsonMissingPath('user.password');
    $this->getJson('/api/session')->assertOk()->assertJsonPath('user.role', 'admin');
});

test('admin redirects to its panel after browser login', function () {
    $this->post('/login', ['email' => $this->admin->email, 'password' => 'password'])->assertRedirect(route('admin.home'));
});

test('student list contains only students and searches without leaking paths', function () {
    $student = User::factory()->create(['first_name' => 'Sofia', 'cv_path' => 'cvs/private.pdf']);
    StudentProfile::create(['user_id' => (string) $student->getKey(), 'kardex_path' => 'kardex/private.pdf']);
    User::factory()->create(['role' => 'company']);
    $this->actingAs($this->admin)->getJson('/api/admin/students?q=Sofia')->assertOk()->assertJsonPath('total', 1)->assertJsonPath('data.0.id', (string) $student->getKey())->assertJsonStructure(['data' => [['cv_url', 'kardex_url']]])->assertJsonMissingPath('data.0.cv_path')->assertJsonMissingPath('data.0.password');
});

test('admin can download both real private documents and missing files return 404', function () {
    Storage::fake('local');
    Storage::disk('local')->put('cvs/student.pdf', '%PDF-test');
    Storage::disk('local')->put('kardex/student.pdf', '%PDF-test');
    $student = User::factory()->create(['cv_path' => 'cvs/student.pdf', 'cv_name' => 'CV.pdf']);
    StudentProfile::create(['user_id' => (string) $student->getKey(), 'kardex_path' => 'kardex/student.pdf', 'kardex_original_name' => 'Kardex.pdf']);
    $id = $student->getKey();
    $this->actingAs($this->admin)->get('/admin/students/'.$id.'/cv')->assertDownload('CV.pdf');
    $this->get('/admin/students/'.$id.'/kardex')->assertDownload('Kardex.pdf');
    Storage::disk('local')->delete('cvs/student.pdf');
    $this->getJson('/api/admin/students/'.$id.'/cv')->assertNotFound();
    $other = User::factory()->create(['role' => 'student']);
    $this->actingAs($other)->getJson('/api/admin/students/'.$id.'/kardex')->assertForbidden();
});

test('company detail joins only its own vacancies and applications', function () {
    $company = User::factory()->create(['role' => 'company', 'company_name' => 'Horizonte', 'rfc' => 'HOD240101AB1']);
    $vacancy = Vacancy::create(['company_user_id' => (string) $company->getKey(), 'title' => 'Desarrollo web', 'status' => 'published']);
    Application::create(['company_user_id' => (string) $company->getKey(), 'vacancy_id' => (string) $vacancy->getKey(), 'full_name' => 'Ana', 'status' => 'pending']);
    Application::create(['company_user_id' => 'another', 'full_name' => 'No mostrar', 'status' => 'pending']);
    $this->actingAs($this->admin)->getJson('/api/admin/companies/'.$company->getKey())->assertOk()->assertJsonPath('company.rfc', 'HOD240101AB1')->assertJsonPath('applications.total', 1)->assertJsonPath('applications.data.0.vacancy', 'Desarrollo web');
    $this->get('/admin/companies/'.$company->getKey())->assertOk()->assertSee('Desarrollo web');
});

test('membership CRUD changes the same public catalog and deactivation preserves history', function () {
    $this->actingAs($this->admin)->postJson('/api/admin/memberships', planFields(['code' => 'nuevo', 'name' => 'Nuevo plan']))->assertCreated();
    $plan = Membership::first();
    $this->patchJson('/api/admin/memberships/'.$plan->getKey(), ['price' => 250])->assertOk()->assertJsonPath('price', 250);
    $this->getJson('/api/memberships')->assertOk()->assertJsonPath('data.0.name', 'Nuevo plan');
    $this->deleteJson('/api/admin/memberships/'.$plan->getKey())->assertOk();
    expect(Membership::count())->toBe(1);
    $company = User::factory()->create(['role' => 'company']);
    $this->actingAs($company)->getJson('/api/memberships')->assertJsonPath('total', 0);
    $this->get('/company/membership/change')->assertOk()->assertDontSee('Nuevo plan');
    $this->actingAs($this->admin)->patchJson('/api/admin/memberships/'.$plan->getKey(), ['active' => true])->assertOk();
    $this->actingAs($company)->get('/company/membership/change')->assertOk()->assertSee('Nuevo plan');
});

test('membership validation rejects duplicate code negative price and invalid benefits', function () {
    Membership::create(planFields());
    $this->actingAs($this->admin)->postJson('/api/admin/memberships', planFields())->assertUnprocessable()->assertJsonValidationErrors('code');
    $this->postJson('/api/admin/memberships', planFields(['code' => 'otro', 'price' => -1, 'benefits' => []]))->assertUnprocessable()->assertJsonValidationErrors(['price', 'benefits']);
    $this->patchJson('/api/admin/memberships/'.Membership::first()->getKey(), ['code' => 'cambiar'])->assertUnprocessable();
});

test('web membership form accepts lines of benefits and shows persisted edits', function () {
    $fields = planFields();
    unset($fields['benefits']);
    $fields['benefits_text'] = "Un beneficio\nOtro beneficio";
    $this->actingAs($this->admin)->post('/admin/memberships', $fields)->assertRedirect(route('admin.memberships.index'));
    expect(Membership::first()->benefits)->toBe(['Un beneficio', 'Otro beneficio']);
    $this->get('/admin/memberships/'.Membership::first()->getKey().'/edit')->assertOk()->assertSee('Otro beneficio');
});

test('company order takes identity price and snapshots from the server', function () {
    $plan = Membership::create(planFields());
    $company = User::factory()->create(['role' => 'company', 'company_name' => 'Nexo']);
    $this->actingAs($company)->postJson('/api/company/membership/orders', ['membership_id' => (string) $plan->getKey(), 'billing_email' => $company->email])->assertCreated()->assertJsonPath('amount', 150)->assertJsonPath('payment_status', 'pending')->assertJsonPath('company_user_id', (string) $company->getKey());
    $order = Subscription::first();
    $plan->update(['price' => 999, 'name' => 'Plan cambiado', 'benefits' => ['Distinto']]);
    expect($order->fresh()->membership_name)->toBe('Basic');
    expect($order->fresh()->amount)->toBe(150.0);
    expect($order->fresh()->membership_benefits)->toBe(['Publicar vacantes']);
    $this->getJson('/api/company/membership')->assertJsonPath('current_subscription', null);
});

test('client cannot choose payment status amount owner or buy an inactive plan', function () {
    $plan = Membership::create(planFields());
    $company = User::factory()->create(['role' => 'company']);
    $body = ['membership_id' => (string) $plan->getKey(), 'billing_email' => $company->email];
    $this->actingAs($company)->postJson('/api/company/membership/orders', $body + ['amount' => 1, 'payment_status' => 'paid', 'company_user_id' => 'another'])->assertUnprocessable()->assertJsonValidationErrors(['amount', 'payment_status', 'company_user_id']);
    $plan->update(['active' => false]);
    $this->postJson('/api/company/membership/orders', $body)->assertNotFound();
    expect(Subscription::count())->toBe(0);
});

test('company only cancels its own pending order and never deletes history', function () {
    $company = User::factory()->create(['role' => 'company']);
    $order = Subscription::create(['company_user_id' => (string) $company->getKey(), 'payment_status' => 'pending', 'status' => 'pending']);
    $other = User::factory()->create(['role' => 'company']);
    $this->actingAs($other)->patchJson('/api/company/membership/orders/'.$order->getKey().'/cancel')->assertNotFound();
    $this->actingAs($company)->patchJson('/api/company/membership/orders/'.$order->getKey().'/cancel')->assertOk()->assertJsonPath('payment_status', 'cancelled');
    $this->patchJson('/api/company/membership/orders/'.$order->getKey().'/cancel')->assertConflict();
    expect(Subscription::count())->toBe(1);
});

test('payment filters support status company and end date without start date', function () {
    $company = User::factory()->create(['role' => 'company', 'company_name' => 'Horizonte']);
    Subscription::create(['company_user_id' => (string) $company->getKey(), 'payment_status' => 'pending', 'membership_name' => 'Plus', 'amount' => 350]);
    Subscription::create(['company_user_id' => (string) $company->getKey(), 'payment_status' => 'failed', 'amount' => 350]);
    $this->actingAs($this->admin)->getJson('/api/admin/payments?q=Horizonte&payment_status=pending&to='.now()->toDateString())->assertOk()->assertJsonPath('total', 1)->assertJsonPath('data.0.membership_name', 'Plus');
    $this->getJson('/api/admin/payments?from=2026-10-26&to=2026-10-01')->assertUnprocessable();
});

test('local simulator is explicit idempotent and activates monthly validity', function () {
    $company = User::factory()->create(['role' => 'company']);
    $order = Subscription::create(['company_user_id' => (string) $company->getKey(), 'payment_status' => 'pending', 'membership_name' => 'Plus', 'amount' => 350]);
    $this->artisan('nextstep:simulate-payment', ['id' => (string) $order->getKey()])->assertSuccessful();
    $this->artisan('nextstep:simulate-payment', ['id' => (string) $order->getKey()])->assertFailed();
    expect($order->fresh()->payment_method)->toBe('simulation');
    $this->actingAs($company)->getJson('/api/company/membership')->assertJsonPath('current_subscription.payment_status', 'paid');
});

test('simulator refuses production and can record a failed payment in testing', function () {
    $order = Subscription::create(['payment_status' => 'pending', 'status' => 'pending']);
    $this->app->instance('env', 'production');
    $this->artisan('nextstep:simulate-payment', ['id' => (string) $order->getKey()])->assertFailed();
    expect($order->fresh()->payment_status)->toBe('pending');
    $this->app->instance('env', 'testing');
    $this->artisan('nextstep:simulate-payment', ['id' => (string) $order->getKey(), '--failed' => true])->assertSuccessful();
    expect($order->fresh()->payment_status)->toBe('failed');
});

test('expired memberships do not appear as current', function () {
    $company = User::factory()->create(['role' => 'company']);
    Subscription::create(['company_user_id' => (string) $company->getKey(), 'payment_status' => 'paid', 'status' => 'active', 'started_at' => now()->subMonths(2), 'ended_at' => now()->subMonth()]);
    $this->actingAs($company)->getJson('/api/company/membership')->assertJsonPath('current_subscription', null);
});

test('all admin pages render empty state and enforce valid document identifiers', function () {
    $this->actingAs($this->admin);
    foreach (['students', 'companies', 'memberships', 'memberships/create', 'payments'] as $path) {
        $this->get('/admin/'.$path)->assertOk()->assertSee('Administración');
    }
    $this->getJson('/api/admin/students/not-an-object-id')->assertNotFound();
    $this->getJson('/api/admin/students/012345678901234567890123/other')->assertNotFound();
});

test('catalog preparation preserves existing prices and validates unique codes', function () {
    Membership::create(planFields(['price' => 777]));
    $this->artisan('nextstep:prepare-memberships')->assertSuccessful();
    $this->artisan('nextstep:prepare-memberships')->assertSuccessful();
    expect(Membership::count())->toBe(3);
    expect(Membership::where('code', 'basic')->first()->price)->toBe(777.0);
});

test('admin creation is controlled and does not promote existing accounts', function () {
    $this->artisan('nextstep:create-admin', ['email' => 'newadmin@example.test'])
        ->expectsQuestion('Nombre del administrador', 'Ximena')
        ->expectsQuestion('Contraseña (8 a 72 caracteres)', 'AdminTest123!')
        ->expectsQuestion('Repite la contraseña', 'AdminTest123!')->assertSuccessful();
    expect(User::where('email', 'newadmin@example.test')->first()->role)->toBe('admin');
    $this->artisan('nextstep:create-admin', ['email' => 'newadmin@example.test'])
        ->expectsQuestion('Nombre del administrador', 'Otra')
        ->expectsQuestion('Contraseña (8 a 72 caracteres)', 'AdminTest123!')
        ->expectsQuestion('Repite la contraseña', 'AdminTest123!')->assertFailed();
});

test('vacancy publishing requires paid validity and obeys the purchased vacancy limit', function () {
    $company = User::factory()->create(['role' => 'company']);
    $fields = ['title' => 'Desarrollo web', 'modality' => 'Remoto', 'location' => 'Monterrey', 'stay_duration' => '3 meses', 'salary_fixed' => 5000, 'periodicity' => 'Por mes', 'description' => 'Prácticas de desarrollo', 'benefits' => ['Capacitación']];
    $this->actingAs($company)->postJson('/company/vacancies', $fields)->assertUnprocessable()->assertJsonValidationErrors('membership');
    Subscription::create(['company_user_id' => (string) $company->getKey(), 'payment_status' => 'paid', 'status' => 'active', 'started_at' => now()->subDay(), 'ended_at' => now()->addMonth(), 'membership_vacancy_limit' => 1]);
    $this->post('/company/vacancies', $fields)->assertRedirect();
    $this->postJson('/company/vacancies', $fields)->assertUnprocessable()->assertJsonValidationErrors('membership');
    expect(Vacancy::count())->toBe(1);
});

test('payments cannot be marked paid or deleted through the legacy API', function () {
    $order = Subscription::create(['payment_status' => 'pending']);
    $this->actingAs($this->admin)->putJson('/api/subscriptions/'.$order->getKey(), ['payment_status' => 'paid'])->assertStatus(405);
    $this->deleteJson('/api/subscriptions/'.$order->getKey())->assertStatus(405);
    expect($order->fresh()->payment_status)->toBe('pending');
});

test('payment detail and active company subscription render stored snapshots', function () {
    $company = User::factory()->create(['role' => 'company', 'company_name' => 'Nexo']);
    $order = Subscription::create(['company_user_id' => (string) $company->getKey(), 'membership_name' => 'Plus histórico', 'membership_benefits' => ['Beneficio histórico'], 'currency' => 'MXN', 'amount' => 350, 'payment_status' => 'paid', 'status' => 'active', 'started_at' => now()->subDay(), 'ended_at' => now()->addMonth()]);
    $this->actingAs($this->admin)->get('/admin/payments/'.$order->getKey())->assertOk()->assertSee('Plus histórico');
    $this->get('/admin/payments')->assertOk()->assertSee('Nexo');
    $this->actingAs($company)->get('/company/membership')->assertOk()->assertSee('Beneficio histórico');
});

test('document filters distinguish complete and missing student profiles', function () {
    $complete = User::factory()->create(['cv_path' => 'cvs/complete.pdf']);
    StudentProfile::create(['user_id' => (string) $complete->getKey(), 'kardex_path' => 'kardex/complete.pdf']);
    User::factory()->create(['cv_path' => 'cvs/without-kardex.pdf']);
    User::factory()->create();
    $this->actingAs($this->admin)->getJson('/api/admin/students?documents=complete')->assertOk()->assertJsonPath('total', 1);
    $this->getJson('/api/admin/students?documents=missing')->assertOk()->assertJsonPath('total', 2);
});
