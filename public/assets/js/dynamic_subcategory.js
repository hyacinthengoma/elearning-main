document.addEventListener('DOMContentLoaded', function () {
    const categoryField = document.querySelector('#Teachers_category');
    const subcategoryField = document.querySelector('#Teachers_subcategory');
    console.log(categoryField);
    console.log(subcategoryField);
    // Écoutez les changements dans le champ "catégorie"
    categoryField.addEventListener('change', function () {
        const categoryId = this.value;
        console.log(categoryId);
        // Utilisez une requête AJAX pour obtenir les sous-catégories liées à la catégorie sélectionnée
        // Remplacez cette partie avec votre propre logique AJAX
        fetch(`/category/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                // Mettez à jour le champ "sous-catégorie" avec les nouvelles options
                subcategoryField.innerHTML = ''; // Effacez les options existantes

                // Ajoutez les nouvelles options
                data.subcategories.forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    subcategoryField.appendChild(option);
                });
        console.log(data.subcategories);
            })
            .catch(error => {
                console.error('Erreur lors de la requête AJAX :', error);
            });
    });
});
