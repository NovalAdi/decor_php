var map = L.map('map').setView([-6.9730963561257555, 107.63030307952417], 17);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

L.marker([-6.9730963561257555, 107.63030307952417]).addTo(map).bindPopup('Find us here')
    .openPopup();