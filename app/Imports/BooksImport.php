<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Storage;

class BooksImport implements ToModel
{
    public function model(array $row)
    {
        // Validation et insertion des données
        return new Book([
            'title' => $row[0], // Titre
            'author' => $row[1], // Auteur
            'isbn' => $row[2], // ISBN
            'copies_total' => $row[3], // Copies totales
            'copies_available' => $row[4], // Copies disponibles
            'category_id' => $row[5], // ID de catégorie
            'cover_image' => isset($row[6]) ? $this->storeCoverImage($row[6]) : null, // Image de couverture (si elle existe)
            'status' => $this->determineStatus($row[4], $row[3]), // Statut basé sur les copies disponibles
        ]);
    }

    /**
     * Fonction pour déterminer le statut du livre en fonction des copies disponibles
     */
    private function determineStatus($copies_available, $copies_total)
    {
        return $copies_available > 0 ? 'available' : ($copies_total > 0 ? 'unavailable' : 'out_of_stock');
    }

    /**
     * Fonction pour gérer le stockage de l'image de couverture
     */
    private function storeCoverImage($cover_image_path)
    {
        // Utilisez cette fonction si vous souhaitez stocker les images
        // L'implémentation ci-dessous est un exemple basique
        $imageName = Str::random(10) . '.' . pathinfo($cover_image_path, PATHINFO_EXTENSION);

        // Sauvegarder l'image dans le dossier public/cover_images
        Storage::disk('public')->put('cover_images/' . $imageName, file_get_contents($cover_image_path));

        return 'cover_images/' . $imageName;
    }
}
