class Client {
  constructor(data) {
    this.id = data.client_id;
    this.name = data.name;
    this.phone = data.phone || 'No disponible';
    this.address = data.address || 'No disponible';
    this.email = data.email || 'No disponible';
  }
}
window.Client = Client;