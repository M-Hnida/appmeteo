<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Météo</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f0f4f8; 
            color: #333; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .weather-card { 
            background: white; 
            padding: 2.5rem; 
            border-radius: 1rem; 
            box-shadow: 0 10px 15px -3px rgba(60, 84, 161, 0.32); 
            text-align: center;
            min-width: 30rem;
            border: 1px solid #7c7c7cff;
        }
        h1 { margin-top: 0; color: #1f2937; margin-bottom: 1.5rem; }
        .temp { font-size: 3.5rem; font-weight: bold; color: #3b82f6; margin: 1rem 0; }
        .error { color: #ef4444; background: #fee2e2; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-weight: 500;}
        .details { color: #6b7280; margin-bottom: 1.5rem; display: flex; justify-content: space-around; }
        
        .search-form {
            display: flex;
            margin-bottom: 2rem;
            gap: 0.5rem;
        }
        .search-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .search-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .search-button {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
            font-weight: 600;
        }
        .search-button:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>

    <div class="weather-card">
        <!-- The Search Form -->
        <form class="search-form" action="/weather" method="GET">
            <input type="text" name="city" value="{{ $city }}" class="search-input" placeholder="Rechercher une ville..." required>
            <button type="submit" class="search-button">Rechercher</button>
        </form>

        @if($error)
            <div class="error">{{ $error }}</div>
        @elseif($weather)
            <h1 style="margin-bottom: 0.5rem;">{{ $city }}</h1>
            <div class="temp">
                {{ $weather['temperature'] }}°C
            </div>
            <div class="details">
                <p>💨 Vent : {{ $weather['windspeed'] }} km/h</p>
                <p>🕒 Heure : {{ now()->setTimezone($timezone)->format('H:i') }}</p>
            </div>
        @else
            <p>Aucune donnée disponible pour le moment.</p>
        @endif
    </div>

</body>
</html>
