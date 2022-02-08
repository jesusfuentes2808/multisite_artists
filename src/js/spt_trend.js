function listTrend(){
    $("#trend_content").css('display', 'none');
    $(".in_trend_content__loading").css('display', 'block');

    fetch(window.urlJson + "/in_trend/in_trend.json")
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
                        <div class="vtr__card__image">
                            <img loading="lazy" src="${images[0].url}" alt='${artistsAll}'>
                        </div>
                        <div class="vtr__card__info">
                            <div class="vtr__card__info__top">
                                <h2 class="title">${name}</h2>
                                <h3 class="sub-title" >${artistListFinal}</h3>
                                <!--<small class="reproductions">350,000 Reproducciones</small>-->
                                <small class="reproductions">Popularidad: ${popularity} %</small>
                            </div>
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
