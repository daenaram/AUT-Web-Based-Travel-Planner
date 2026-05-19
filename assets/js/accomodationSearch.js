document.addEventListener('DOMContentLoaded', function () {
  const panel = document.getElementById('accommodation');
  if (!panel) return;

  const searchButton = panel.querySelector('button.search-btn');
  if (!searchButton) return;

  function submitAccommodationSearch() {
    const inputs = Array.from(panel.querySelectorAll('input[name]'));
    const values = inputs.reduce((result, input) => {
      if (input.name && input.type !== 'button' && input.type !== 'submit') {
        result[input.name] = input.value.trim();
      }
      return result;
    }, {});

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/AUT-Web-Based-Travel-Planner/Pages/userDashboard/search/accomodationSearch.php';

    Object.entries(values).forEach(([name, value]) => {
      const hiddenInput = document.createElement('input');
      hiddenInput.type = 'hidden';
      hiddenInput.name = name;
      hiddenInput.value = value;
      form.appendChild(hiddenInput);
    });

    document.body.appendChild(form);
    form.submit();
  }

  // Click handler
  searchButton.addEventListener('click', function (e) {
    e.preventDefault();
    submitAccommodationSearch();
  });

  // Allow submitting with Enter in any input inside the panel
  panel.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      submitAccommodationSearch();
    }
  });
});
