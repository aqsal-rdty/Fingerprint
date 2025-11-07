@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="weather-card d-flex justify-content-between align-items-center p-4 shadow-sm rounded">
        <!-- Bagian kiri -->
        <div>
            <h3 class="fw-bold text-muted mb-1">admin</h3>
            <p class="text-secondary mb-0">
                <i class="fa fa-map-marker-alt"></i> Bogor, Indonesia
            </p>
        </div>

        <!-- Bagian kanan -->
        <div class="text-end">
            <p id="city-temp" class="text-secondary mb-0" style="font-size: 2.5rem;">--°</p>
            <img id="weather-icon" src="" alt="weather icon" width="100" style="display:none;">
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
.weather-card {
    background: #fff;
    border: none;
}
.text-muted {
    color: #888 !important;
}
.text-secondary {
    color: #bbb !important;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const city = "Bogor";
    const apiKey = "123abc456def789ghi123jkl456";

    const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${apiKey}`;

    fetch(url)
        .then(res => res.json())
        .then(data => {
            console.log("Weather data:", data); // debug di console

            if (data.cod === 200) {
                const temp = Math.round(data.main.temp);
                const icon = data.weather[0].icon;
                const iconUrl = `https://openweathermap.org/img/wn/${icon}@2x.png`;

                document.getElementById('city-temp').innerText = `${temp}°`;
                document.getElementById('weather-icon').src = iconUrl;
                document.getElementById('weather-icon').style.display = 'inline';
            } else {
                document.getElementById('city-temp').innerText = "--°";
            }
        })
        .catch(error => {
            console.error("Error fetching weather:", error);
            document.getElementById('city-temp').innerText = "--°";
        });
});
</script>
@endsection