// Apunta a tu API local. Asegúrate de que la ruta sea correcta.
const API_URL = 'api/clients';

document.addEventListener('DOMContentLoaded', () => {
  loadClients();
});

async function loadClients() {
  try {
    const response = await fetch(API_URL);
    if (!response.ok) {
      throw new Error('Error al cargar los clientes: ' + response.statusText);
    }
    const clients = await response.json();
    populateTable(clients);
  } catch (error) {
    console.error(error);
    alert('No se pudieron cargar los clientes. Revisa la consola para más detalles.');
  }
}

function populateTable(clients) {
  const tbody = document.querySelector('#tabla-clientes tbody');
  tbody.innerHTML = ''; // Limpiar la tabla

  clients.forEach(clientData => {
    const client = new window.Client(clientData);
    const tr = document.createElement('tr');

    tr.innerHTML = `
      <td>${client.name}</td>
      <td>${client.email}</td>
      <td>${client.phone}</td>
      <td>
        <button class="btn btn-sm btn-primary btn-detail" data-id="${client.id}">
          Ver detalles
        </button>
      </td>
    `;
    
    tr.querySelector('.btn-detail').addEventListener('click', onDetailClick);
    tbody.appendChild(tr);
  });
}

async function onDetailClick(event) {
  const id = event.currentTarget.getAttribute('data-id');
  try {
    const response = await fetch(`${API_URL}/${id}`);
    if (!response.ok) {
      throw new Error('Error al cargar los detalles del cliente.');
    }
    const clientData = await response.json();
    showClientModal(new window.Client(clientData));
  } catch (error) {
    console.error(error);
    alert('No se pudo cargar el detalle del cliente.');
  }
}

function showClientModal(client) {
  document.getElementById('modal-name').textContent = client.name;
  document.getElementById('modal-email').textContent = client.email;
  document.getElementById('modal-phone').textContent = client.phone;
  document.getElementById('modal-address').textContent = client.address;

  const modalEl = document.getElementById('modal-cliente');
  const bsModal = new bootstrap.Modal(modalEl);
  bsModal.show();
}