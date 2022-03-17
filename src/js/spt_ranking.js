function listRanking(){
    $("#ranking_content").css('display', 'none');
    $(".ranking_content__loading").css('display', 'block');
    //fetch(window.urlJson + "/" + window.alias + "/.json")
    //fetch(window.urlJson + "/ranking/ranking.json")
    //fetch(window.url + "/ranking/ranking.json")
    fetch(window.url + "/ranking")
        .then(async res => {
            return res.json();
        })
        .then(async data => {

            data.items.forEach((item) => {
                console.log("-------------------ITEM RANKING---------------------");
                console.log(item.response);
                const {id, name, album, artists, popularity} = item.response;
                const {images} = album;
                console.log(id);

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
                                <a href="#" data-type="ranking" class="follow_playlist_spotify_link vtr__card__info__add" data-id="${id}">
                                    <img loading="lazy" src="./assets/images/icon-open-plus.svg" alt="imagen">
                                </a>
                            </div>
                        </div>
                    `);

                window['spt_ranking_'+id] = '{"id": "' + id + '", "image": "' + images[0].url + '", "name": "' + name + '", "artist_all": "' + artistsAll + '", "artist_list_final": "'+artistListFinal+'"}';
            });

             $("#ranking_content").css('display', 'grid');
            $(".ranking_content__loading").css('display', 'none');
        });
}

listRanking();
