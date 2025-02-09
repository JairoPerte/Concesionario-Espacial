// Mostrar el popup para eliminar cuenta
document
  .getElementById("delete-account-btn")
  .addEventListener("click", function () {
    document.getElementById("delete-popup").style.display = "flex";
    document.getElementById("confirm-delete").setAttribute("disabled", "true");

    // Temporizador de 5 segundos
    let countdown = 5;
    const countdownInterval = setInterval(() => {
      if (countdown >= 0) {
        document.getElementById(
          "confirm-delete"
        ).innerText = `Eliminar Cuenta (${countdown})`;
        countdown--;
      } else {
        document.getElementById("confirm-delete").innerText = `Eliminar Cuenta`;
        document.getElementById("confirm-delete").removeAttribute("disabled");
        document.getElementById("confirm-delete");
        clearInterval(countdownInterval);
      }
    }, 1000);
  });

// Cancelar la eliminación de la cuenta
document.getElementById("cancel-delete").addEventListener("click", function () {
  document.getElementById("delete-popup").style.display = "none";
});

// Confirmar la eliminación de la cuenta
document
  .getElementById("confirm-delete")
  .addEventListener("click", function () {
    document.getElementById("delete-popup").style.display = "none";
    document.getElementById("form_eliminar").submit();
  });
document
  .getElementById("form_eliminar")
  .addEventListener("submit", function () {
    event.preventDefault();
  });

// Para que ponga el menú seleccionado azul
document.querySelectorAll(".menu a").forEach((link) => {
  link.addEventListener("click", function () {
    document
      .querySelectorAll(".menu a")
      .forEach((el) => el.classList.remove("active"));
    this.classList.add("active");
  });
});
