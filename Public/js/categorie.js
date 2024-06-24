document.addEventListener('DOMContentLoaded', async (event) => {
  const reponse = await fetch("http://localhost:8000/?controller=api-categorie&action=api-liste-categorie");
  const categories = await reponse.json();
  updateCategories(categories);

  console.log(categories);

});



function updateCategories(categories) {
  alert("OK");
  const tableBody = document.querySelector('tbody');
  // const btn=document.getElementById("modifier");
  tableBody.innerHTML = '';
  categories["categories"].forEach(categorie => {
    console.log(categorie);


    const row = document.createElement('tr');
    
    row.classList.add('bg-white', 'border-b', 'dark:bg-gray-800', 'dark:border-gray-700');
    row.innerHTML = `
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              ${categorie["nomCategorie"]}
          </th>
          <td class="px-6 py-4">
              <a id="modifier" class=" text-purple-600  dark:text-purple-400 hover:text-purple-800"
                  href="?controller=categorie&action=update-categorie&id=${categorie["idCategorie"]}">Modifier</a>
              <a class="text-red-400 hover:text-red-900 ml-4"
                  href="?controller=categorie&action=delete-categorie&id=${categorie["idCategorie"]}"
                  onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">Supprimer</a>
          </td>
      `;

    tableBody.appendChild(row);
  });
//   btn.addEventListener('click', function () {
//     loadUpdateForm(categories["idCategorie"]);
// });
}


function loadUpdateForm(idCategorie) {
  const form = document.querySelector('form');
  form.action = `<?= WEBROOT ?>/?controller=categorie&action=update-categorie&id=${idCategorie}`;
  form.method = 'POST';
  form.submit();
}



