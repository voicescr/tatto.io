$(document).ready(function () {
i18next
  .use(i18nextHttpBackend)
  .init({
      lng: 'es',
      backend: {
          loadPath: 'locales/{{lng}}/{{ns}}.json'
      },
      fallbackLng: 'es', 
      //debug: true,
    }, function(err, t) {
      jqueryI18next.init(i18next, $);
      $('.body').localize();

      $('.lang-select').click(function() {
        i18next.changeLanguage(this.innerHTML, function() {
           $('.nav').localize();
           $('.header').localize();
           $('.gallery').localize();
           $('.services').localize();
           $('.contact').localize();
        });
      });
  });
});
