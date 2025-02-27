<?php
include 'database.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alle Pokémon Kaarten</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-gray-800 p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="text-white text-2xl font-bold">Pokédex</div>
            <ul class="flex space-x-6">
                <li><a href="index.php" class="text-gray-300 hover:text-white">Home</a></li>
                <li><a href="cards.php" class="text-gray-300 hover:text-white">Mijn Verzameling</a></li>
            </ul>
        </div>
    </nav>
    <div class="max-w-7xl mx-auto px-8 py-12">
        <h2 class="text-3xl font-bold mb-8">Alle Pokémon Kaarten</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($Cards as $Card): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="<?php echo $Card['image_url']; ?>" alt="<?php echo $Card['name']; ?>" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2"><?php echo $Card['name']; ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo $Card['type']; ?> Pokémon</p>
                        <a href="card-detail.php?id=<?php echo $Card['id']; ?>" class="text-blue-600 hover:text-blue-800">Meer informatie →</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>