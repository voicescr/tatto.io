$(document).ready(function () {
  const sendMail = (contact) => {
    // save the **mailsender** folder on public_html file
    // change the localURL to prod URL like http://domain.com/mailsender/public/email/send
    axios
      .post("http://localhost:80/mailsender/public/email/send", contact)
      .then((response) => {
        //document.getElementById("btnSubmit").disabled = false;
        $('input[type="submit"]').prop('disabled', false);
        document.getElementById("contactForm").reset();
        window.alert(`Su mensaje ha sido enviado con éxito`);
      })
      .catch((error) => console.error(error));
  };

  const form = document.querySelector("form");

  const formEvent = form.addEventListener("submit", (event) => {
    event.preventDefault();
    //document.getElementById("btnSubmit").disabled = true;
    $('input[type="submit"]').prop('disabled', true);
    const email = document.querySelector("#email").value;
    const name = document.querySelector("#name").value;
    const message = document.querySelector("#message").value;

    const contact = { email, name, message };
    sendMail(contact);
  });
});
