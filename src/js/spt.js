//[{"title":"Salsa","codigo_de_playlist":"7bzmal7pgKQccKqfaxzYaJ","response":{"error":{"status":404,"message":"Not found."}}}]
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

                window['spt_main_'+id] = '{"id": "' + images[0].url + '", "name": "' + name + ', "followers": "' +followers.total+'", "popularity": "'+promPopularity+'"}';
            });

            $("#spt_content").css('display', 'grid');
            $(".spt_content_content__loading").css('display', 'none');
        });
}

listPlayListSP();
