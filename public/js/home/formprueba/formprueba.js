document.addEventListener('DOMContentLoaded',()=>{
  const phoneInput = document.querySelector('#prueba-phone');
  if (!phoneInput) return;

  const iti = window.intlTelInput(phoneInput,{
    initialCountry:'pe',
    preferredCountries:['pe','cl','co','mx','ar','br'],
    utilsScript:'https://cdn.jsdelivr.net/npm/intl-tel-input@18.3.1/build/js/utils.js'
  });

  phoneInput.addEventListener('countrychange',()=>{
      document.querySelector('.prueba-phonePais').value = iti.getSelectedCountryData().iso2;
      document.querySelector('.prueba-namePais').value  = iti.getSelectedCountryData().name;
  });
});
