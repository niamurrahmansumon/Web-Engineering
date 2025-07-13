function search() {
  const input = document.querySelector('.search-box input');
  if (input.value.trim() !== "") {
    alert(`You searched for: ${input.value}`);
  } else {
    alert("Please enter a search term.");
  }
}