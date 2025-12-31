@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-3">📊 Dashboard Admin</h3>

<canvas id="userChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = @json($usersPerDay->pluck('date'));
const data = @json($usersPerDay->pluck('total'));

new Chart(document.getElementById('userChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'User Terdaftar',
            data: data,
            borderWidth: 2,
            tension: 0.3
        }]
    }
});
</script>
@endsection
