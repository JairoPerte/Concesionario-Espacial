let currentPage = 1;
let totalPages = 1;
let elemPerPage = 10; // Valor por defecto

function loadSpaceships(page) {
  const tbody = document.getElementById("tabla-body");
  tbody.innerHTML = "<tr><td colspan='9'>Cargando...</td></tr>";

  const userIdElement = document.getElementById("sesion-id");
  const userId = userIdElement ? userIdElement.dataset.sesion_id : null;

  history.pushState(
    { page: page, limit: elemPerPage },
    "",
    `?page=${page}&limit=${elemPerPage}`
  );

  fetch(`/getSpaceShips.php?page=${page}&limit=${elemPerPage}`)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Error en la respuesta: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      tbody.innerHTML = "";

      if (!data.ships || data.ships.length === 0) {
        tbody.innerHTML =
          "<tr><td colspan='9'>No hay naves disponibles.</td></tr>";
        return;
      }

      data.ships.forEach((ship) => {
        const row = document.createElement("tr");
        row.className = "spaceship";
        row.innerHTML = `
          <td><a href="/spaceships/${ship.id}">${ship.name}</a></td>
          <td>${ship.license_plate}</td>
          <td>${ship.speed}</td>
          <td>${ship.creddits}</td>
          <td>${ship.sale == 1 ? "Sí" : "No"}</td>
          <td>${ship.company_name}</td>
          <td>${
            ship.planet_name
              ? `<a href="/planetarium/${ship.Planet_id}">${ship.planet_name}</a>`
              : "Ninguno"
          }</td>
          <td>${
            ship.user_nickname
              ? `<a href="/profile/${ship.User_id}">${ship.user_nickname}</a>`
              : "Ninguno"
          }</td>
          <td>${
            userId == ship.User_id
              ? `
            <form action="/spaceships/${ship.id}/edit" method="get">
              <button class="button edit"><i class="fas fa-edit"></i> Editar</button>
            </form>
            <form action="/spaceships/${ship.id}" method="post">
              <button class="button delete"><i class="fas fa-trash-alt"></i> Borrar</button>
            </form>`
              : ""
          }
          </td>
        `;
        tbody.appendChild(row);
      });

      totalPages = data.totalPages || 1;
      document.getElementById(
        "page-info"
      ).textContent = `Página ${page}/${totalPages}`;
      document.getElementById("prev-page").disabled = page === 1;
      document.getElementById("next-page").disabled = page === totalPages;
    })
    .catch((error) => {
      console.error("Error cargando naves espaciales:", error);
      tbody.innerHTML =
        "<tr><td colspan='9'>Error al cargar los datos.</td></tr>";
    });
}

window.addEventListener("popstate", (event) => {
  if (event.state) {
    currentPage = event.state.page;
    elemPerPage = event.state.limit;
    document.getElementById("selected-limit").textContent = elemPerPage;
    loadSpaceships(currentPage);
  }
});

document.addEventListener("DOMContentLoaded", () => {
  loadSpaceships(currentPage);
});

document.getElementById("prev-page").addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    loadSpaceships(currentPage);
  }
});

document.getElementById("next-page").addEventListener("click", () => {
  if (currentPage < totalPages) {
    currentPage++;
    loadSpaceships(currentPage);
  }
});

const selectDisplay = document.getElementById("select-display");
const selectOptions = document.getElementById("select-options");
const arrow = document.getElementById("arrow");
const selectedLimit = document.getElementById("selected-limit");

selectDisplay.addEventListener("click", () => {
  selectOptions.classList.toggle("show");
  arrow.classList.toggle("rotate");
});

document.querySelectorAll(".select-options li").forEach((option) => {
  option.addEventListener("click", (e) => {
    elemPerPage = parseInt(e.target.getAttribute("data-value"));
    selectedLimit.textContent = elemPerPage;
    selectOptions.classList.remove("show");
    arrow.classList.remove("rotate");
    currentPage = 1;
    loadSpaceships(currentPage);
  });
});
