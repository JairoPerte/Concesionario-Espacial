let currentPage = 1;
let totalPages = 1;
// Probamos con un elemento por Página estático
const elemPerPage = 9;

function loadSpaceships(page) {
  const list = document.getElementById("spaceship-list");
  const userId = document.getElementById("user-id").dataset.id;
  list.innerHTML = "<p>Cargando...</p>";
  history.pushState(
    {
      page: page,
    },
    "",
    `?page=${page}`
  );

  fetch(`/getSpaceShips.php?page=${page}&limit=${elemPerPage}&id=${userId}`)
    .then((response) => response.json())
    .then((data) => {
      const list = document.getElementById("spaceship-list");
      list.innerHTML = "";
      data.ships.forEach((ship) => {
        const div = document.createElement("div");
        div.className = "spaceship";
        div.innerHTML = `<h4><a href="/spaceships/${ship.id}">${ship.name}</a></h4><p>Velocidad: ${ship.speed} km/h</p><p>Precio: ${ship.creddits} créditos</p>`;
        list.appendChild(div);
      });
      totalPages = data.totalPages;
      document.getElementById(
        "page-info"
      ).textContent = `Página ${page}/${totalPages}`;
      document.getElementById("prev-page").disabled = page === 1;
      document.getElementById("next-page").disabled = page === totalPages;
    });
}

window.addEventListener("popstate", (event) => {
  if (event.state) {
    currentPage = event.state.page;
    loadSpaceships(currentPage);
  }
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

document.addEventListener("DOMContentLoaded", () => {
  loadSpaceships(currentPage);
});

document.getElementById("prev-page").disabled = currentPage === 1;
document.getElementById("next-page").disabled = currentPage === totalPages;
