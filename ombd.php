<?php
//860d1004

$apiKey = '860d1004';

// 1. Словник категорій (ключ для API => Емоджі та назва для UI)
$categories = [
    'space'     => '🚀 Космос',
    'detective' => '🕵️ Детективи',
    'robot'     => '🤖 Роботи',
    'future'    => '🌆 Майбутнє',
    'magic'     => '🪄 Магія',
    'dark'      => '🌒 Нуар та трилери',
    'love'      => '❤️ Романтика',
    'cyber'     => '🦾 Кіберпанк',
    'time'      => '⏳ Подорожі у часі'
];

// 2. Визначення активної категорії
$requestedCat = $_GET['cat'] ?? 'space';

if ($requestedCat === 'random' || !array_key_exists($requestedCat, $categories)) {
    // Якщо натиснуто "Здивуй мене" або категорія невідома — обираємо випадковий ключ
    $currentCat = array_rand($categories);
} else {
    $currentCat = $requestedCat;
}

// 3. Параметри сортування та фільтрації
$sortMode   = $_GET['sort'] ?? 'gap';   // gap, imdb, meta, year
$filterMode = $_GET['filter'] ?? 'all'; // all, modern (>=2000), classic (<2000)

$movies = [];

// 4. Отримання даних з OMDb API за активною категорією
$url = "http://www.omdbapi.com/?apikey={$apiKey}&s=" . urlencode($currentCat) . "&type=movie";
$searchData = json_decode(@file_get_contents($url), true);

if (isset($searchData['Search'])) {
    foreach ($searchData['Search'] as $item) {
        $detailUrl = "http://www.omdbapi.com/?apikey={$apiKey}&i={$item['imdbID']}";
        $d = json_decode(@file_get_contents($detailUrl), true);

        // Перевірка цілісності даних
        if (
            isset($d['imdbRating'], $d['Metascore']) &&
            $d['imdbRating'] !== 'N/A' && 
            $d['Metascore'] !== 'N/A' && 
            $d['Poster'] !== 'N/A'
        ) {
            $imdb100   = (float)$d['imdbRating'] * 10;
            $meta      = (int)$d['Metascore'];
            $ratingGap = abs($imdb100 - $meta);

            $movies[$d['Title']] = [
                'year'   => (int)$d['Year'],
                'imdb'   => (float)$d['imdbRating'],
                'meta'   => $meta,
                'gap'    => $ratingGap,
                'poster' => $d['Poster']
            ];
        }
    }
}

// 5. Фільтрація масиву (array_filter)
if ($filterMode === 'modern') {
    $movies = array_filter($movies, fn($m) => $m['year'] >= 2000);
} elseif ($filterMode === 'classic') {
    $movies = array_filter($movies, fn($m) => $m['year'] < 2000);
}

// 6. Сортування масиву (uasort + match)
match ($sortMode) {
    'imdb'  => uasort($movies, fn($a, $b) => $b['imdb'] <=> $a['imdb']),
    'meta'  => uasort($movies, fn($a, $b) => $b['meta'] <=> $a['meta']),
    'year'  => uasort($movies, fn($a, $b) => $b['year'] <=> $a['year']),
    default => uasort($movies, fn($a, $b) => $b['gap'] <=> $a['gap']), // 'gap'
};
?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>CineGap Explorer</title>
    <style>
    body {
        font-family: system-ui, sans-serif;
        background: #0f172a;
        color: #f8fafc;
        padding: 20px;
        margin: 0;
    }

    .container {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Кнопки категорій */
    .category-bar {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .cat-btn {
        padding: 8px 14px;
        border-radius: 20px;
        background: #1e293b;
        color: white;
        text-decoration: none;
        border: 1px solid #334155;
        font-size: 0.9rem;
        transition: 0.2s;
    }

    .cat-btn:hover {
        background: #334155;
    }

    .cat-btn.active {
        background: #0284c7;
        border-color: #38bdf8;
        font-weight: bold;
    }

    .cat-btn.random {
        background: #ec4899;
        border-color: #f472b6;
        font-weight: bold;
    }

    /* Панель фільтрації та сортування */
    .filter-bar {
        background: #1e293b;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
        border: 1px solid #334155;
    }

    select,
    button {
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #334155;
        background: #0f172a;
        color: white;
    }

    button {
        background: #38bdf8;
        color: #0f172a;
        font-weight: bold;
        border: none;
        cursor: pointer;
    }

    /* Сітка */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
        gap: 20px;
    }

    .card {
        background: #1e293b;
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #334155;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        border-radius: 6px;
    }

    .badge-gap {
        background: #ec4899;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: bold;
        display: inline-block;
        margin-top: 6px;
    }
    </style>
</head>

<body>

    <div class="container">
        <h1>🎬 CineGap Explorer</h1>

        <!-- 1. Панель швидких категорій -->
        <div class="category-bar">
            <?php foreach ($categories as $key => $label): ?>
            <?php 
                $isActive = ($currentCat === $key) ? 'active' : ''; 
                $url = "?cat={$key}&sort={$sortMode}&filter={$filterMode}";
            ?>
            <a href="<?= $url ?>" class="cat-btn <?= $isActive ?>"><?= $label ?></a>
            <?php endforeach; ?>

            <!-- Кнопка "Здивуй мене" -->
            <a href="?cat=random&sort=<?= $sortMode ?>&filter=<?= $filterMode ?>" class="cat-btn random">🎲 Здивуй
                мене!</a>
        </div>

        <!-- 2. Панель налаштувань сортування та фільтрації -->
        <form method="GET" class="filter-bar">
            <input type="hidden" name="cat" value="<?= htmlspecialchars($currentCat) ?>">

            <label>
                Сортувати за:
                <select name="sort">
                    <option value="gap" <?= $sortMode === 'gap'  ? 'selected' : '' ?>>🔥 Індексом розбіжності</option>
                    <option value="imdb" <?= $sortMode === 'imdb' ? 'selected' : '' ?>>⭐ Рейтингом глядачів (IMDb)
                    </option>
                    <option value="meta" <?= $sortMode === 'meta' ? 'selected' : '' ?>>🎯 Рейтингом критиків
                        (Metacritic)</option>
                    <option value="year" <?= $sortMode === 'year' ? 'selected' : '' ?>>📅 Роком виходу</option>
                </select>
            </label>

            <label>
                Фільтр епохи:
                <select name="filter">
                    <option value="all" <?= $filterMode === 'all'     ? 'selected' : '' ?>>🌐 Усі роки</option>
                    <option value="modern" <?= $filterMode === 'modern'  ? 'selected' : '' ?>>🔥 XXI століття (≥ 2000)
                    </option>
                    <option value="classic" <?= $filterMode === 'classic' ? 'selected' : '' ?>>📜 Класика (<
                            2000)</option>
                </select>
            </label>

            <button type="submit">Застосувати</button>
        </form>

        <p style="color: #94a3b8;">
            Обрана категорія: <strong><?= $categories[$currentCat] ?></strong>
            | Знайдено та відфільтровано: <strong><?= count($movies) ?></strong> фільмів
        </p>

        <!-- 3. Видача фільмів -->
        <div class="grid">
            <?php
        if (empty($movies)) {
            echo "<p>Фільмів за обраними критеріями не знайдено.</p>";
        } else {
            // Вивід за допомогою array_walk()
            array_walk($movies, function($movie, $title) {
                echo "
                <div class='card'>
                    <div>
                        <img src='{$movie['poster']}' alt='{$title}'>
                        <h3 style='font-size:0.9rem; margin:10px 0 4px;'>{$title} ({$movie['year']})</h3>
                        <p style='font-size:0.75rem; color:#94a3b8; margin:0;'>
                            IMDb: <strong>{$movie['imdb']}</strong> | Meta: <strong>{$movie['meta']}</strong>
                        </p>
                    </div>
                    <div>
                        <span class='badge-gap'>Розрив: {$movie['gap']} б.</span>
                    </div>
                </div>";
            });
        }
        ?>
        </div>
    </div>

</body>

</html>