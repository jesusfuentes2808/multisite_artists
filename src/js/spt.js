//[{"title":"Salsa","codigo_de_playlist":"7bzmal7pgKQccKqfaxzYaJ","response":{"error":{"status":404,"message":"Not found."}}}]
function listTrend(){
    $("#trend_content").css('display', 'none');
    $(".in_trend_content__loading").css('display', 'block');

    fetch(window.urlJson + "/in_trend/in_trend.json")
        .then(async res => {
            return res.json();
        })
        .then(async data => {
            data.forEach((item) => {
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
                            <a href="#" class="button follow_track_spotify_link" data-id="${id}">Agregar a mi lista</a>
                        </div>
                    </div>`);
            });

            $("#trend_content").css('display', 'grid');
            $(".in_trend_content__loading").css('display', 'none');
        });
}


function listRanking(){
    $("#ranking_content").css('display', 'none');
    $(".ranking_content__loading").css('display', 'block');
    //fetch(window.urlJson + "/" + window.alias + "/.json")
    fetch(window.urlJson + "/ranking/ranking.json")
        .then(async res => {
            return res.json();
        })
        .then(async data => {
            data.forEach((item) => {
                //console.log("-------------------ITEM RANKING---------------------");
                //console.log(item.response);
                const {name, album, artists, popularity} = item.response;
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

                $('#ranking_content').append(`
                        <div class="vtr__card vtr__card--playlist">
                            <div class="vtr__card__image">
                                <img loading="lazy" src="${images[0].url}" alt='${artistsAll}'>
                            </div>
                            <div class="vtr__card__info">
                                <div class="vtr__card__info__top">
                                    <h2 class="title">${name}</h2>
                                    <h3 class="sub-title">${artistListFinal}</h3>
                                </div>
                                <a href="#" class="vtr__card__info__add">
                                    <img loading="lazy" src="./assets/images/icon-open-plus.svg" alt="imagen">
                                </a>
                            </div>
                        </div>
                    `);
            });


            $("#ranking_content").css('display', 'grid');
            $(".ranking_content__loading").css('display', 'none');
        });
}

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

function listPlayListSP(){
    $("#spt_content").css('display', 'none');
    $(".spt_content_content__loading").css('display', 'block');

    fetch(window.urlJson + "/" + window.alias + "/playlist_sp.json" )
        .then(async res => {
            return res.json();
        })
        .then(async data => {
            data.items.forEach((item) => {
                const {name, description, images, followers, tracks, id} = item.response;
                const {items} = tracks;

                let popularityProm = 0;
                const valuePopularity = items.map((item) => item.track.popularity)
                const totalItemsPopularity = valuePopularity.length;
                const sumPopularity = valuePopularity.reduce((a, b) => a + b, 0);
                const promPopularity = (sumPopularity / totalItemsPopularity).toFixed(2);

                $("#spt_content").append( `
                                <div class="vtr__card">
                                    <div class="vtr__card__image">
                                        <img loading="lazy" src="${images[0].url}" alt="imagen">
                                        <div class="type">
                                            <img loading="lazy" src="./assets/images/play-spotify.svg" alt="imagen">
                                        </div>
                                    </div>
                                    <div class="vtr__card__info">
                                        <div class="vtr__card__info__top">
                                            <h2 class="title text-center">${name}</h2>
                                           <div class="follo-popu">
                                               <div class="followers">
                                                   <span class="number">${followers.total}</span>
                                                   <span class="text">Seguidores</span>
                                               </div>
                                               <div class="popular">
                                                   <div class="boxs">
                                                       <div class="box"></div>
                                                       <div class="box"></div>
                                                       <div class="box"></div>
                                                       <div class="box"></div>
                                                       <div class="box"></div>
                                                   </div>
                                                   <span class="text">Popularidad: ${promPopularity} % </span>
                                               </div>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="vtr__card__bottom">
                                        <a href="#" class="button follow_playlist_spotify_link" data-id="${id}">Agregar a mi lista</a>
                                    </div>
                                </div>
                            `);
            });

            $("#spt_content").css('display', 'grid');
            $(".spt_content_content__loading").css('display', 'none');
        });
}

listTrend();
listRanking();
listArtistWeek();
listPlayListSP();
