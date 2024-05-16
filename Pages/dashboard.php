<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: loginPage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            background-color: #C47B7B;
            width: 250px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }
        .sidebar img {
            width: 100px;
            padding-bottom: 25px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .sidebar .logout-btn {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .widget {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .widget h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>
<?php include '../Component/sidebar.php'; ?>
    <div class="content">
        <h1>Dashboard</h1>
        <div class="widget" id="weather-widget">
            <h2>Weather</h2>
            <p>Loading...</p>
        </div>
        <div class="widget" id="news-widget">
            <h2>Latest News</h2>
            <p>Loading...</p>
        </div>
    </div>

    <script>
        function logout() {
            window.location.href = '../Component/backlogin.php?logout=true';
        }

               // Fetch weather data
               async function fetchWeather() {
            const city = 'Lyon';
            const url = `../Component/weather_proxy.php?city=${city}`;
            try {
                const response = await fetch(url);
                const data = await response.json();

                if (response.ok && data.main && data.weather) {
                    const icon = data.weather[0].icon;
                    const widget = document.getElementById('weather-widget');
                    widget.innerHTML = `
                        <h2>Weather</h2>
                        <h3>Ville : ${city} </h3>
                        <p>Temperature: ${data.main.temp} °C</p>
                        <p>Weather: <img src="http://openweathermap.org/img/wn/${icon}.png" alt="${data.weather[0].description}"> </p>
                    `;
                } else {
                    throw new Error('Weather data not found');
                }
            } catch (error) {
                console.error('Error fetching weather data:', error);
                document.getElementById('weather-widget').innerHTML = `
                    <h2>Weather</h2>
                    <p>Unable to fetch weather data</p>
                `;
            }
        }

        // Fetch news data
        async function fetchNews() {
            const url = `../Component/news_proxy.php?country=fr`; // Chemin vers le proxy NewsAPI
            try {
                const response = await fetch(url);
                const data = await response.json();
                console.log('News data:', data); // Log des données pour le débogage

                if (response.ok && data.articles) {
                    const widget = document.getElementById('news-widget');
                    const articles = data.articles.slice(0, 5).map(article => `
                        <div>
                            <h3>${article.title}</h3>
                            <a href="${article.url}" target="_blank">Read more</a>
                        </div>
                    `).join('');
                    widget.innerHTML = `
                        <h2>Latest News</h2>
                        ${articles}
                    `;
                } else {
                    throw new Error('News data not found');
                }
            } catch (error) {
                console.error('Error fetching news data:', error);
                document.getElementById('news-widget').innerHTML = `
                    <h2>Latest News</h2>
                    <p>Unable to fetch news data</p>
                `;
            }
        }

        fetchWeather();
        fetchNews();
    </script>
</body>
</html>
