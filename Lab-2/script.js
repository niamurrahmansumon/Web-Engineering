document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        console.log(`Search query: ${query}`);
        // Add search functionality here (e.g., filter content or fetch results)
    });
});