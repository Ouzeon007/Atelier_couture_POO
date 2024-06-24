
// const libelle = document.getElementById('libelle');
// const qte = document.getElementById('qte');
// const prix = document.getElementById('prix');
// const btn = document.getElementById("btn")
// const select = document.getElementById("select")
// const select2 = document.getElementById("select2")
// // const btnType=document.getElementById("btntype");

// function checkRequired(inputTab) {
//     let isValid = true;
//     inputTab.forEach(function (input) {
//         if (input.value.length == 0) {
//             error(input, 'Le champs est requis');
//             isValid = false;
//         } else {
//             success(input);
//         }

//     });
//     return isValid;
// }
// btn.addEventListener('click', function (event) {

//     const allFieldsValid = checkRequired([libelle, qte, prix, select, select2]);
//     if (!allFieldsValid) {
//         event.preventDefault();
//     }

// });
// btn.addEventListener('click', function (event) {

//     const allFieldsValid = checkRequired([libelle]);
//     if (!allFieldsValid) {
//         event.preventDefault();
//     }

// });

// function error(input, message = 'Error') {
//     //Recuperer la div mere:
//     const divParent = input.parentNode;
//     input.classList.remove('border-green-500');
//     input.classList.add('border-red-400')
//     const small = divParent.querySelector('small');
//     if (small) {
//         small.innerText = message;
//     } else {
//         const small = document.createElement('small');
//         small.innerText = message;
//         small.classList.add('text-red-400')
//         divParent.appendChild(small);
//     }
// }
// function success(input) {
//     //Recuperer la div mere:
//     const divParent = input.parentNode;
//     input.classList.remove('border-red-500')
//     input.classList.add('border-green-500');
//     const small = divParent.querySelector('small');
//     if (small) {
//         small.remove();
//     }


// }