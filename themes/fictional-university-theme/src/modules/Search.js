import $ from "jquery"

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.addSearchHTML(); // keep at top of constructor because must create the element before following code will work 
    this.resultsDiv = $("#search-overlay__results")
    this.openButton = $(".js-search-trigger")
    this.closeButton = $(".search-overlay__close")
    this.searchOverlay = $(".search-overlay")
    this.searchField = $("#search-term")
    this.searchFieldHTML = document.getElementById("search-term")

    this.events()
    this.isOverlayOpen = false
    this.isSpinnerVisible = false
    this.previousValue
    this.typingTimer
  }

  // 2. events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this))
    this.closeButton.on("click", this.closeOverlay.bind(this))
    $(document).on("keydown", this.keyPressDispatcher.bind(this))
    this.searchField.on("keyup", this.typingLogic.bind(this))
  }

  // 3. methods (function, action...)
  typingLogic() {
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer)

      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.html('<div class="spinner-loader"></div>')
          this.isSpinnerVisible = true
        }
        this.typingTimer = setTimeout(this.getResults.bind(this),400)
      } else {
        this.resultsDiv.html("")
        this.isSpinnerVisible = false
      }
    }

    this.previousValue = this.searchField.val()
  }

  getResults() {
    let x = `${universityData.root_url}/wp-json/university/v1/search?term=${this.searchField.val()}`;
    $.getJSON(x, (results) => {
        this.resultsDiv.html(`
          <div class="row">
            <div class="one-third">
              <h2 class="search-overlay__section-title">General Information</h2>
              ${results.generalInfo.length  >= 1 ? '<ul class="link-list min-list">' : '<p><strong>No General Info match this search. </strong></p>'}
              ${results.generalInfo.map(item => `<li><a href="${item.permalink}">${item.title}</a>${item.postType == 'post' ? ` by <em>${item.authorName}</em>` : ''}</li>`).join("")}
              ${results.generalInfo.length  >= 1 ? '</ul>': ''}
            </div>
            <div class="one-third">
               <h2 class="search-overlay__section-title">Programs</h2>
              ${results.programs.length  >= 1 ? '<ul class="link-list min-list">' : `<p><strong>No Programs match this search. </strong></p><p><a href="${universityData.root_url}/archives/programs">View all programs</a></p>`}
             ${results.programs.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join("")}
              ${results.programs.length > 0 ? '</ul>': ''}

               <h2 class="search-overlay__section-title">Professors</h2>
                ${results.professors.length > 0  ? '<ul class="professor-cards link-list min-list">' : `<p><strong>No Professors match this search. </strong></p><p><a class="" href="${universityData.root_url}/professors">View all professors</a></p>`}

                ${results.professors.map(item => `
                <li>
                <a class="professor-card" href="${item.permalink}">
                  <img class="professor-card__image" src="${item.thumbnail}" alt=""><span class="professor-card__name">${item.title}</span></a></li>`).join("")}
              ${results.professors.length > 0 ? '</ul>': ''}
            </div>
            <div class="one-third">
              <h2 class="search-overlay__section-title">Campuses</h2>
            ${results.campuses.length > 0 ? '<ul class="link-list min-list">' : `<p><strong>No Campuses match this search. </strong></p><p><a href="${universityData.root_url}/archives/campuses">View all campuses</a></p>`}
             ${results.campuses.map(item => `<li><a href="${item.permalink}">${item.title}</a>${item.type == 'post' ? ` by <em>${item.authorName}</em>` : ''}</li>`).join("")}
              ${results.campuses.length >= 1 ? '</ul>': ''}
               <h2 class="search-overlay__section-title">Events</h2>
               ${results.events.length > 0 ? '<ul class="link-list min-list">' : `<p><strong>No Events match this search.</strong></p><p><a href="${universityData.root_url}/archives/events">View all events</a></p>`}
             ${results.events.map(item => `
             <div class="event-summary">
                  <a class="event-summary__date t-center" href="${item.permalink}">
                    <span class="event-summary__month">${item.month}</span>
                    <span class="event-summary__day">${item.day}</span>  
                  </a>
                  <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                    <p>${item.description} <a href="${item.permalink}" class="nu gray">Learn more</a></p>
                  </div>
                </div> 
            `).join("")}
              ${results.events.length >= 1 ? '</ul>': ''}
            </div>
          </div>
          `)
    })
  this.isSpinnerVisible = false;
  }
    // Delete this code a bit later on
    // $.when(
    //  $.getJSON(`${universityData.root_url}/wp-json/wp/v2/posts?search=${this.searchField.val()}`),
    //  $.getJSON(`${universityData.root_url}/wp-json/wp/v2/pages?search=${this.searchField.val()}`)
    // ).then((posts,pages) => {
      
    //   let combinedResults = posts[0].concat(pages[0]);
    //   this.resultsDiv.html(`
    //     <h2 class="search-overlay__section-title">General Information</h2>
    //   ${ combinedResults.length ? '<ul class="link-list min-list">' : '<p><strong>The keywords did not return any results, try searching again. </strong></p>'}
    //       ${combinedResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a>${item.type =- 'post' ? ` by <em>${item.authorName}</em>` : ''}</li>`).join("")}
    //      ${ combinedResults.length ? '</ul>': ''}
    //   `);
    //   this.isSpinnerVisible = false;
    //   }, () => {
    //     this.resultsDiv.html('Unexpected error, please try again.');//fallback incase cannot connect db
    //   }
    // );
  

  keyPressDispatcher(e) {
    if (e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(":focus")) {
      this.openOverlay()
    }

    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay()
    }
  }

  openOverlay() {
    
    this.searchOverlay.addClass("search-overlay--active")
    $("body").addClass("body-no-scroll");
    console.log("our open method just ran!")
    this.isOverlayOpen = true;
    this.searchField.val('');
    setTimeout( () => this.searchFieldHTML.focus(),302);
    return false;
  }



  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active")
    $("body").removeClass("body-no-scroll")
    console.log("our close method just ran!")
    this.isOverlayOpen = false
  }

  addSearchHTML() {
    $('body').append(
      `
        <div class="search-overlay">
          <div class="search-overlay__top">
            <div class="container">
              <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
              <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
              <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
            </div>
          </div>
          <div class="container">
            <div id="search-overlay__results"></div>
          </div>
  </div>
      `
    )
  }
}

export default Search
