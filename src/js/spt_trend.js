function listTrend(){
    $("#trend_content").css('display', 'none');
    $(".in_trend_content__loading").css('display', 'block');

    //fetch(window.urlJson + "/trend")
    fetch(window.url + "/trend")
        .then(async res => {
            return res.json();
        })
        .then(async data => {
            data.items.forEach((item) => {
                const {name, album, artists, popularity, id} = item.response;
                const {images} = album;

                const artistList = artists.map((item)=> item.name);


                let artistListFinal = '';
                if(artistList.length > 3){
                    for (let i=0; i < 3; i++){
                        artistListFinal += (artistList[i] + ((i !== 2)? ', ' : ', +'));
                    }
                } else {
                    artistListFinal  = artistList.join(',');
                }

                const artistsAll = artistList.join(',');

                $('#trend_content').append(
                    `<div class="vtr__card">
                        <a href="https://open.spotify.com/track/${id}" target="_blank" style="display: inline-block;z-index: 11111;position: relative;">
                            <div class="vtr__card__image">
                                    <img loading="lazy" src="${images[0].url}" alt='${artistsAll}'>
                            </div>
                        </a>
                        <div class="vtr__card__info">
                            <a href="https://open.spotify.com/track/${id}" target="_blank">
                                <div class="vtr__card__info__top">
                                    <h2 class="title">${name}</h2>
                                    <h3 class="sub-title" >${artistListFinal}</h3>
                                    <!--<small class="reproductions">350,000 Reproducciones</small>-->
                                    <small class="reproductions">Popularidad: ${popularity} %</small>
                                </div>
                                <div class="card__spotify">
                                       <img src="/assets/images/Spotify_Logo_Green.png" alt="spotify">
                                </div>
                            </a>
                        </div>
                        <div class="vtr__card__bottom">
                            <a href="#" class="button follow_track_spotify_link" data-id="${id}" data-type="trend">Agregar a mi lista</a>
                        </div>
                    </div>`);

                window['spt_trend_'+id] = '{"id": "' + id + '", "image": "' + images[0].url + '", "name": "' + name + '", "artist_all": "' + artistsAll.replace(/"/g, "\'") + '", "artist_list_final": "'+artistListFinal.replace(/\\"/g, "\\'")+'"}';
            });

            $("#trend_content").css('display', 'grid');
            $(".in_trend_content__loading").css('display', 'none');
        });
}

listTrend();
