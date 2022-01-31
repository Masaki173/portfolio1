'use strict';
console.log('radioFee');
 
 function priceSwitch() {
      const formBox = document.getElementById('pricing-form');
  　　const radioFee = document.getElementsByClassName('radioFee');
        if(radioFee[0].checked){
        formBox.style.display = "none";
      }else if(radioFee[1].checked){
        formBox.style.display = "block";
      }
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
