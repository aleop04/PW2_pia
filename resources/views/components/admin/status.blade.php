@php
$labels = ['pending' => 'Pendiente', 'paid' => 'Pagado', 'failed' => 'Fallido', 'cancelled' => 'Cancelado', 'active' => 'Activa', 'expired' => 'Vencida', 'accepted' => 'Aceptada', 'rejected' => 'Rechazada', 'published' => 'Publicada', 'closed' => 'Cerrada'];
@endphp
<span class="admin-badge @if(in_array($status, ['pending'])) admin-badge--pending @elseif(in_array($status, ['failed', 'rejected'])) admin-badge--failed @elseif(in_array($status, ['cancelled', 'expired', 'closed'])) admin-badge--neutral @endif">{{ $labels[$status] ?? $status ?? 'Sin registrar' }}</span>
