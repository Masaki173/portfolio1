'use strict';
console.log('radioFee');
 function priceSwitch() {
    const formBox = document.getElementById('pricing-form');
  const radioFee = document.getElementsByClassName('radioFee');
      formBox.style.display = "none";
        radioFee[0].addEventListener('change', function (){
        formBox.style.display = "none";
      });
        radioFee[1].addEventListener('change', function (){
        formBox.style.display = "block";
      });
  }
// {
//     var priceForm = document.getElementById("priceForm");
//       priceForm.addEventListener('keydown',function(){
//       var form_value = priceForm.value;
//     if (form_value.match(/[0-9]+/g) != form_value ) {
//   	document.getElementById('alert').innerHTML = '数値でお値段を入力してください';
//     priceForm.value = '';
//   }
//   });
// }
