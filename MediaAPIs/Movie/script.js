const movieSearchBox = document.getElementById('movie-search-box');
const searchList = document.getElementById('search-list');
const resultGrid = document.getElementById('result-grid');

// load movies from API
async function loadMovies(searchTerm) {
    const URL = `https://api.themoviedb.org/3/search/movie?api_key=e446bc89015229cf337e16b0849d506c&language=en-US&query=${searchTerm}&page=1&include_adult=true`;
    const res = await fetch(`${URL}`);
    const data = await res.json();
    var results = data['results']
    console.log(results);
    if (data) displayMovieList(results);
}

function findMovies() {
    let searchTerm = (movieSearchBox.value).trim();
    if (searchTerm.length > 0) {
        searchList.classList.remove('hide-search-list');
        loadMovies(searchTerm);
    } else {
        searchList.classList.add('hide-search-list');
    }
}

function displayMovieList(movies) {
    searchList.innerHTML = "";
    //NOTE: TRY TO REDUCE THE LENGTH OF THE LOOP. USE AT MOST 3 TO REDUCE API CALLS.
    for (let idx = 0; idx < movies.length; idx++) {
        let movieListItem = document.createElement('div');
        movieListItem.dataset.id = movies[idx]['id']; // setting movie id in  data-id
        movieListItem.classList.add('search-list-item');
        if (movies[idx]['poster_path'] != "")
            moviePoster = movies[idx]['poster_path'];
        else
            moviePoster = "https://i.ibb.co/hRCvsdq/image-not-found.png";
        movieListItem.innerHTML = `
        <div class = "search-item-thumbnail">
            <img src = "https://image.tmdb.org/t/p/w185/${moviePoster}">
        </div>
        <div class = "search-item-info">
            <h3>${movies[idx]['original_title']}</h3>
            <p>${movies[idx]['release_date']}</p>
        </div>`;
        searchList.appendChild(movieListItem);
    }
    loadMovieDetails();
}

function loadMovieDetails() {
    const searchListMovies = searchList.querySelectorAll('.search-list-item');
    searchListMovies.forEach(movie => {
        movie.addEventListener('click', async() => {
            // console.log(movie.dataset.id);
            searchList.classList.add('hide-search-list');
            movieSearchBox.value = "";

            const result = await fetch(`https://api.themoviedb.org/3/movie/${movie.dataset.id}?api_key=e446bc89015229cf337e16b0849d506c&language=en-US`);
            const movieDetails = await result.json();
            // console.log(movieDetails);
            displayMovieDetails(movieDetails);
        });
    });
}

function displayMovieDetails(details) {
    resultGrid.innerHTML = `
    <div class = "movie-poster">
        <img src = "${(details['poster_path'] != null) ? "https://image.tmdb.org/t/p/original/"+ details['poster_path'] : "https://i.ibb.co/hRCvsdq/image-not-found.png"}" alt = "movie poster">
    </div>
    <div class = "movie-info">
        <h3 class = "movie-title">${details['original_title']}</h3>
        <ul class = "movie-misc-info">
            <li class = "year">Release Date: ${details['release_date']}</li>
        </ul>
        <p class = "genre"><b>Genre:</b> ${details['genres'][0]['name']}</p>
        <p class = "plot"><b>Plot:</b> ${details['overview']}</p>
        <p class = "language"><b>Language:</b> ${details['original_language']}</p>
        
    </div>
    `;
}


window.addEventListener('click', (event) => {
    if (event.target.className != "form-control") {
        searchList.classList.add('hide-search-list');
    }
});