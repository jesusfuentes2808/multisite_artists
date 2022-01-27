function listArtistWeek(){
    $("#week_contect").css('display', 'none');
    $(".week_contect_content__loading").css('display', 'block');

    fetch(window.urlJson + "/page_artist_item/page_artist_item.json")
        .then(async res => {
            return res.json();
        })
        .then(async data => {
            console.log("-------------------DATA ITEM listArtistWeek---------------------");
            console.log(data.items);
            data.items.forEach((item) => {
                console.log("-------------------ITEM listArtistWeek---------------------");
                console.log(item);
                const {name, album, artists, popularity} = item.response;
                const {images} = album;

                const artistList = artists.map((item) => item.name);

                let artistListFinal = '';
                if (artistList.length > 3) {
                    for (let i = 0; i < 3; i++) {
                        artistListFinal += (artistList[i] + ((i !== 2) ? ', ' : ', +'));
                    }
                } else {
                    artistListFinal = artistList.join(',');
                }

                const artistsAll = artistList.join(',');

                $('#week_contect').append(`
                            <div class="image">
                                <img loading="lazy" src="${images[0].url}" alt="${name}">
                            </div>
                        `);
            });

            $("#week_contect").css('display', 'grid');
            $(".week_contect_content__loading").css('display', 'none');
        });
}

listArtistWeek();
