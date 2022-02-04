'use strict';
console.log('radioFee');

 function priceSwitch() {
    const formBox = document.getElementById('pricing-form');
  const radioFee = document.getElementsByClassName('radioFee');
        if(radioFee[0].checked){
        formBox.style.display = "none";
      }else if(radioFee[1].checked){
        formBox.style.display = "inline-block";
      }
  }
window.onload = priceSwitch;
