<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\StudentProfile;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function students(Request $request): mixed
    {
        $filters = $request->validate(['q' => 'nullable|string|max:100', 'documents' => 'nullable|in:complete,missing']);
        $kardexIds = StudentProfile::whereNotNull('kardex_path')->where('kardex_path', '!=', '')->pluck('user_id')->all();
        $completeQuery = User::where('role', 'student')->whereNotNull('cv_path')->where('cv_path', '!=', '')->whereIn('_id', $kardexIds);
        $total = User::where('role', 'student')->count();
        $complete = $completeQuery->count();
        $summary = [$total, $complete, $total - $complete];
        $query = User::where('role', 'student');
        if (($filters['documents'] ?? null) === 'complete') {
            $query->whereNotNull('cv_path')->where('cv_path', '!=', '')->whereIn('_id', $kardexIds);
        } elseif (($filters['documents'] ?? null) === 'missing') {
            $query->where(fn ($query) => $query->whereNull('cv_path')->orWhere('cv_path', '')->orWhereNotIn('_id', $kardexIds));
        }
        if (! empty($filters['q'])) {
            $query->where(function ($query) use ($filters) {
                foreach (['first_name', 'paternal_last_name', 'maternal_last_name', 'email'] as $field) {
                    $query->orWhere($field, 'like', '%'.$filters['q'].'%');
                }
            });
        }
        $students = $query->latest()->paginate(15)->withQueryString();
        $profiles = StudentProfile::whereIn('user_id', $students->getCollection()->map(fn ($user) => (string) $user->getKey())->all())->get()->keyBy('user_id');
        $students->through(fn ($user) => $this->studentData($user, $profiles->get((string) $user->getKey())));

        return ($request->expectsJson() || $request->is('api/*')) ? response()->json($students) : view('admin.students.index', compact('students', 'summary'));
    }

    private function studentData(User $user, ?StudentProfile $profile): array
    {
        $id = (string) $user->getKey();

        return [
            'id' => $id,
            'name' => trim($user->first_name.' '.$user->paternal_last_name.' '.$user->maternal_last_name),
            'email' => $user->email,
            'phone' => $user->phone,
            'birth_date' => $user->birth_date?->format('Y-m-d'),
            'cv_url' => $user->cv_path ? route('admin.students.document', [$id, 'cv']) : null,
            'kardex_url' => $profile?->kardex_path ? route('admin.students.document', [$id, 'kardex']) : null,
        ];
    }

    public function student(Request $request, string $id): mixed
    {
        $user = User::where('role', 'student')->findOrFail($id);
        $student = $this->studentData($user, StudentProfile::where('user_id', $id)->first());
        $student['application_count'] = Application::where('student_user_id', $id)->count();

        return ($request->expectsJson() || $request->is('api/*')) ? response()->json($student) : view('admin.students.show', compact('student'));
    }

    public function document(string $id, string $document): mixed
    {
        $user = User::where('role', 'student')->findOrFail($id);
        if ($document === 'cv') {
            $path = $user->cv_path;
            $name = $user->cv_name ?? 'CV.pdf';
        } else {
            $profile = StudentProfile::where('user_id', $id)->first();
            $path = $profile?->kardex_path;
            $name = $profile?->kardex_original_name ?? 'Kardex.pdf';
        }
        abort_unless($path && Storage::disk('local')->exists($path), 404, 'El documento no está disponible.');

        return Storage::disk('local')->download($path, $name, ['Cache-Control' => 'private, no-store']);
    }

    public function companies(Request $request): mixed
    {
        $filters = $request->validate(['q' => 'nullable|string|max:100']);
        $query = User::where('role', 'company');
        if (! empty($filters['q'])) {
            $query->where(fn ($query) => $query->where('company_name', 'like', '%'.$filters['q'].'%')->orWhere('rfc', 'like', '%'.$filters['q'].'%'));
        }
        $companies = $query->latest()->paginate(15)->withQueryString();
        $counts = Application::whereIn('company_user_id', $companies->getCollection()->map(fn ($user) => (string) $user->getKey())->all())->get(['company_user_id'])->countBy('company_user_id');
        $companies->through(fn ($user) => $this->companyData($user) + ['application_count' => $counts->get((string) $user->getKey(), 0)]);
        $summary = [User::where('role', 'company')->count(), Vacancy::count(), Application::count()];

        return ($request->expectsJson() || $request->is('api/*')) ? response()->json($companies) : view('admin.companies.index', compact('companies', 'summary'));
    }

    private function companyData(User $user): array
    {
        $fields = ['company_name', 'email', 'rfc', 'sector', 'custom_sector', 'state', 'city', 'description'];

        return array_merge(array_fill_keys($fields, null), $user->only($fields), ['id' => (string) $user->getKey()]);
    }

    public function company(Request $request, string $id): mixed
    {
        $company = $this->companyData(User::where('role', 'company')->findOrFail($id));
        $vacancies = Vacancy::where('company_user_id', $id)->get(['_id', 'title', 'status']);
        $vacancyMap = $vacancies->keyBy(fn ($vacancy) => (string) $vacancy->getKey());
        $applications = Application::where('company_user_id', $id)->latest()->paginate(15)->withQueryString();
        $applications->through(fn ($application) => [
            'id' => (string) $application->getKey(),
            'student_user_id' => $application->student_user_id,
            'name' => $application->full_name,
            'vacancy' => $vacancyMap->get((string) $application->vacancy_id)?->title ?? 'Vacante no disponible',
            'status' => $application->status,
            'created_at' => $application->created_at?->toIso8601String(),
        ]);
        $vacancies = $vacancies->map(fn ($vacancy) => ['id' => (string) $vacancy->getKey(), 'title' => $vacancy->title, 'status' => $vacancy->status]);

        return ($request->expectsJson() || $request->is('api/*')) ? response()->json(compact('company', 'vacancies', 'applications')) : view('admin.companies.show', compact('company', 'vacancies', 'applications'));
    }

    public function payments(Request $request): mixed
    {
        $filters = $request->validate([
            'q' => 'nullable|string|max:100',
            'payment_status' => 'nullable|in:pending,paid,failed,cancelled',
            'from' => 'nullable|date_format:Y-m-d',
            'to' => ['nullable', 'date_format:Y-m-d', ...($request->filled('from') ? ['after_or_equal:from'] : [])],
        ]);
        $query = Subscription::query();
        if (! empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }
        if (! empty($filters['q'])) {
            $ids = User::where('role', 'company')->where('company_name', 'like', '%'.$filters['q'].'%')->get()->map(fn ($company) => (string) $company->getKey())->all();
            $query->where(fn ($query) => $query->whereIn('company_user_id', $ids)->orWhere('reference', 'like', '%'.$filters['q'].'%'));
        }
        if (! empty($filters['from'])) {
            $query->where('created_at', '>=', Carbon::parse($filters['from'])->startOfDay());
        }
        if (! empty($filters['to'])) {
            $query->where('created_at', '<=', Carbon::parse($filters['to'])->endOfDay());
        }
        $payments = $query->latest()->paginate(15)->withQueryString();
        $companies = User::where('role', 'company')->whereIn('_id', $payments->getCollection()->pluck('company_user_id')->all())->get()->keyBy(fn ($user) => (string) $user->getKey());
        $payments->through(fn ($payment) => $payment->summary($companies->get($payment->company_user_id)));
        $summary = [Subscription::where('payment_status', 'paid')->where('currency', 'MXN')->sum('amount'), Subscription::where('payment_status', 'pending')->count(), Subscription::where('payment_status', 'failed')->count()];

        return ($request->expectsJson() || $request->is('api/*')) ? response()->json($payments) : view('admin.payments.index', compact('payments', 'summary'));
    }

    public function payment(Request $request, string $id): mixed
    {
        $record = Subscription::findOrFail($id);
        $payment = $record->summary(User::where('role', 'company')->find($record->company_user_id));

        return ($request->expectsJson() || $request->is('api/*')) ? response()->json($payment) : view('admin.payments.show', compact('payment'));
    }
}
