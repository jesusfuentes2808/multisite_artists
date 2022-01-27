function listRanking(){
    $("#ranking_content").css('display', 'none');
    $(".ranking_content__loading").css('display', 'block');
    //fetch(window.urlJson + "/" + window.alias + "/.json")
    //fetch(window.urlJson + "/ranking/ranking.json")
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

listRanking();
