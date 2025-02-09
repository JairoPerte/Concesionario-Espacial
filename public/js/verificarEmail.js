// Cuando termine de cargar el documento:
document.addEventListener("DOMContentLoaded", function () {
  const inputs = document.querySelectorAll(".code-input input");
  const verifyBtn = document.querySelector(".verify-btn");
  const form = document.querySelector("#verification-form");
  const hiddenInput = document.querySelector("#hidden-code");
  const errorMessage = document.querySelector(".error-message");

  // Se hace el focus en el primer input para que el usuario no tenga que hacerlo
  inputs[0].focus();

  // Por cada input de código:
  inputs.forEach((input, index) => {
    // Obligamos a que sea un texto sea un text para evitar flechas y 1 de longitud
    input.setAttribute("type", "text");
    input.setAttribute("maxlength", "1");

    // Para cuando escriba por teclado
    input.addEventListener("input", (e) => {
      //Obligamos a que sea todo números lo que introduzca
      e.target.value = e.target.value.replace(/[^0-9]/g, "");
      // Si existe el próximo input y no hay nada escrito se pasa al siguiente
      if (e.target.value.length === 1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
        // Si el usuario ha escrito el último número lo enviamos del tirón sin esperar
      } else if (index == inputs.length - 1) {
        verifyBtn.click();
      }
    });

    // Si pega el usuario pues se lo ponemos a todos los imput
    input.addEventListener("paste", (e) => {
      // Evita el pegado estándar
      e.preventDefault();

      // Obtenemos los datos y los limpiamos
      const pastedData = (e.clipboardData || window.clipboardData).getData(
        "text"
      );
      // Elimina caracteres no numéricos
      const cleanData = pastedData.replace(/[^0-9]/g, "");

      // Reparte los números pegados entre los inputs
      cleanData.split("").forEach((num, i) => {
        if (i < inputs.length) {
          inputs[i].value = num;
        }
      });

      // Si se pegó un código completo, mueve el focus al último input
      if (cleanData.length >= inputs.length) {
        inputs[inputs.length - 1].focus();
        verifyBtn.click(); // Enviar si el código es válido
      }
    });

    // Para cuando presiona las teclas
    input.addEventListener("keydown", (e) => {
      // Si le da a retroceder y no está en la primera pues le damos el focus a la anterior (además el backspace lo elimina de por si)
      if (e.key === "Backspace" && index > 0 && !input.value) {
        inputs[index - 1].focus();
      }
    });
  });

  // Para no comprobar todos los inputs en backend pues se lo asignamos e
  form.addEventListener("submit", function (event) {
    event.preventDefault(); // No lo envía del tirón espera a asignar y las comprobaciones

    let code = "";
    inputs.forEach((input) => (code += input.value));

    // Asigna el código al input hidden
    hiddenInput.value = code;

    if (code.length === 5) {
      form.submit(); // Envía el form si todo está correcto
    } else {
      errorMessage.style.display = "block";
    }
  });
});
