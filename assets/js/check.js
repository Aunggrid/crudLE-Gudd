(() => {
function displayError(elem, message){
    const smallElem = elem.parentElement.querySelector('small');
    smallElem.innerText = message;
    elem.classList.add('invalid');
    form.classList.add('invalid');
}

function validateLength(elem,min,max){
    const val = elem.value;
    if(val.length < min || val.length > max){
        const elemName = elem.getAttribute('name');

      displayError(elem,`${elemName} Only allow ${min}(free) and${max}(not free)`);
    }
}

function validateForm(event){
 event.preventDefault();
 const payElem = document.getElementById('tpay');
 const orderElem = document.getElementById('torder');
 
 validateLength(payElem,0,1);
 
}

function run(){
    const formElem = document.querySelector('form');
    formElem.addEventListener('submit',validateForm);
}





run();
})();