// Initialize Bootstrap tooltips
const tooltipElements = [...document.querySelectorAll('[data-bs-title]')].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

// Disable tooltips when sidebar is not minimized
tooltipElements.forEach(el => el.toggleEnabled());

// Toggle sidebar minimized
document.getElementById('sidebar-toggler').addEventListener('click', () => {
  document.body.classList.toggle('sidebar-minimized');
  tooltipElements.forEach(el => el.toggleEnabled());
});

// Bar Chart
const ctx1 = document.getElementById('bar-chart');
const barChart = new Chart(ctx1, {
  options: {
    responsive: true,
  },
  type: 'bar',
  data: {
    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
    datasets: [{
      label: 'Revenue',
      data: [65, 59, 80, 81, 56, 55],
      backgroundColor: '#008080'
    },
    {
      label: 'Expenses',
      data: [28, 48, 40, 19, 86, 27],
      backgroundColor: '#002929'
    },
    {
      label: 'Profits',
      data: [38, 68, 60, 39, 76, 37],
      backgroundColor: '#6c757d'
    }
    ]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

// Doughnut Chart
const ctx2 = document.getElementById('doughnut-chart');
const doughnutChart = new Chart(ctx2, {
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'bottom'
      }
    }
  },
  type: 'doughnut',
  data: {
    labels: ['Revenue', 'Expenses', 'Profits'],
    datasets: [{
      label: 'Colors',
      data: [300, 50, 100],
      backgroundColor: ['#008080', '#002929', '#6c757d']
    }]
  }
});

// Generate Notifications Data
for (let i = 1; i <= 10; i++) {
  const listItem = document.createElement('div');
  listItem.href = '#';
  listItem.className = 'list-group-item list-group-item-action';
  listItem.innerHTML =  /*html*/ `
  <div class="d-flex w-100 justify-content-between">
    <h5 class="mb-1">Lorem ipsum</h5>
    <small>3 days ago</small>
  </div>
  <p class="mb-1">A new user has been registered</p>
  <div class="d-flex justify-content-between">
    <small>user${Math.round(Math.random() * 100000)}</small>
    <small><a href="#">Mark as Read</a> | <a href="#">Go to</a></small>
  </div>
`;
  document.getElementById('notifications').appendChild(listItem);
}

// Generate Table Data
for (let i = 1; i <= 25; i++) {
  const tr = document.createElement('tr');
  tr.innerHTML = /*html*/ `
                    <td>${i}</td>
                    <td>u${Math.round(Math.random() * 100000)}</td>
                    <td><a href="#">u${Math.round(Math.random() * 100000)}@example.com</a></td>
                    <td><small class="text-bg-success rounded-1 px-1">active</small></td>
                    <td>Member</td>
                    <td>
                      <button class="btn btn-warning mb-1" data-bs-toggle="modal" data-bs-target="#userFormModal"> <i class="bi bi-pencil"></i> </button>
                      <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"> <i class="bi bi-trash"></i> </button>
                    </td>
                `;
  document.querySelector('#table tbody').appendChild(tr);
}

// DataTables
table = new DataTable('#table');

// Select2
$('#userFormModal select').select2({
  dropdownParent: $('#userFormModal'),
  theme: 'bootstrap-5'
});