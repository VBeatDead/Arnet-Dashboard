const findRecord = (keyword, searchFieldId = 'dt-search-0') => {
  const searchField = document.getElementById(searchFieldId)
  searchField.value = keyword
  searchField.dispatchEvent(new Event('input'))
}

const randomInt = (min = 0, max = 9) => Math.floor(Math.random() * (max - min + 1) + min)

const Badge = (text, color) => `<span class="badge text-bg-${color}">${text}</span>`