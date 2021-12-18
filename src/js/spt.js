const nameKey = 'token_auth';

const tokenStorage = localStorage.getItem(nameKey);


const lsDeleteFn = function () {
    try {
        localStorage.removeItem(nameKey);
        return true;
    } catch (e) {
        return false;
    }
};




async function getPlayList(listId) {
    //console.log(listId);

    if(!tokenStorage){
        const credentials = await init();
        //console.log("-------------credentials-------------");
        //console.log(credentials);
    }

    let tokenStorage = localStorage.getItem(nameKey);
    tokenStorage = JSON.parse(tokenStorage);
    //console.log("etPlayList");
    //console.log(tokenStorage);
    const _lsDelete = lsDeleteFn;
    return await fetch("https://api.spotify.com/v1/playlists/" + listId,
        {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': tokenStorage ? tokenStorage.token : '',
            },
        }
    )
        .then(async res => {
            if (res.status !== 200) {
                const lsDelete = _lsDelete();
                if (lsDelete) {
                    await init();
                    await getPlayList(listId);
                }
                return false;
            }
            return res.json();
        })
        .then((data) => {

            const {name, description, images, followers, tracks} = data;
            console.log(data);
            const {items} = tracks;

            let popularityProm = 0;
            const valuePopularity = items.map((item) => item.track.popularity)
            const totalItemsPopularity = valuePopularity.length;
            const sumPopularity = valuePopularity.reduce((a, b) => a + b, 0);
            const promPopularity = (sumPopularity / totalItemsPopularity).toFixed(2);

            return `
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
                        <a href="#" class="button">Agregar a mi lista</a>
                    </div>
                </div>
            `;
        });
}


async function getPlayListTrend(listId) {
    //console.log(listId);

    if(!tokenStorage){
        const credentials = await init();
        //console.log("-------------credentials-------------");
        //console.log(credentials);
    }

    let tokenStorage = localStorage.getItem(nameKey);
    tokenStorage = JSON.parse(tokenStorage);
    //console.log("etPlayList");
    //console.log(tokenStorage);
    const _lsDelete = lsDeleteFn;
    return await fetch("https://api.spotify.com/v1/tracks/" + listId,
        {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': tokenStorage ? tokenStorage.token : '',
            },
        }
    )
        .then(async res => {
            if(res.status === 404){
                return false;
            } else if (res.status !== 200) {
                const lsDelete = _lsDelete();
                if (lsDelete) {
                    await init();
                    await getPlayList(listId);
                }
                return false;
            }
            return res.json();
        })
        .then((data) => {

            const {name, album, artists, popularity} = data;
            const {images} = album;

            const artistList = artists.map((item)=> item.name);
            console.log("TRACK RESPONSE artistList");
            console.log(artistList);

            let artistListFinal = '';
            if(artistList.length > 3){
                for (let i=0; i < 3; i++){
                    artistListFinal += (artistList[i] + ((i !== 2)? ', ' : ', +'));
                }
            } else {
                artistListFinal  = artistList.join(',');
            }

            const artistsAll = artistList.join(',');
            /*const {items} = tracks;

            let popularityProm = 0;
            const valuePopularity = items.map((item) => item.track.popularity)
            const totalItemsPopularity = valuePopularity.length;
            const sumPopularity = valuePopularity.reduce((a, b) => a + b, 0);
            const promPopularity = (sumPopularity / totalItemsPopularity).toFixed(2);
*/
            return `
                <div class="vtr__card">
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
                        <a href="#" class="button">Agregar a mi lista</a>
                    </div>
                </div>
            `;
        });
}

async function getPlayListRanking(listId) {
    //console.log(listId);

    if(!tokenStorage){
        const credentials = await init();
        //console.log("-------------credentials-------------");
        //console.log(credentials);
    }

    let tokenStorage = localStorage.getItem(nameKey);
    tokenStorage = JSON.parse(tokenStorage);
    //console.log("etPlayList");
    //console.log(tokenStorage);
    const _lsDelete = lsDeleteFn;
    return await fetch("https://api.spotify.com/v1/tracks/" + listId,
        {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': tokenStorage ? tokenStorage.token : '',
            },
        }
    )
        .then(async res => {
            if(res.status === 404){
                return false;
            } else if (res.status !== 200) {
                const lsDelete = _lsDelete();
                if (lsDelete) {
                    await init();
                    await getPlayList(listId);
                }
                return false;
            }
            return res.json();
        })
        .then((data) => {

            const {name, album, artists, popularity} = data;
            const {images} = album;

            const artistList = artists.map((item)=> item.name);
            console.log("TRACK RESPONSE artistList");
            console.log(artistList);

            let artistListFinal = '';
            if(artistList.length > 3){
                for (let i=0; i < 3; i++){
                    artistListFinal += (artistList[i] + ((i !== 2)? ', ' : ', +'));
                }
            } else {
                artistListFinal  = artistList.join(',');
            }

            const artistsAll = artistList.join(',');
            /*const {items} = tracks;

            let popularityProm = 0;
            const valuePopularity = items.map((item) => item.track.popularity)
            const totalItemsPopularity = valuePopularity.length;
            const sumPopularity = valuePopularity.reduce((a, b) => a + b, 0);
            const promPopularity = (sumPopularity / totalItemsPopularity).toFixed(2);
*/
            return `
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
            `;
        });
}



async function init() {
    const formBody = [];
    formBody.push('grant_type=client_credentials');

    return await fetch("https://accounts.spotify.com/api/token", {
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Authorization': 'Basic  OGJmOGZhODUzYTM2NGZjYjlkOTk4Y2MyMjk1MGM5YzU6NzdiMGI3MzA3ZTE3NDMwMzk2ZDBmNDA3OTQxNmRkZjM=',
        },
        method: "POST",
        body: formBody,
    })
        .then(res => res.json())
        .then((data) => {
            const {access_token, token_type} = data;
            localStorage.setItem(nameKey, JSON.stringify({token: `${token_type} ${access_token}`}));
            return {access_token, token_type};
        });
}


const initGeneral = async function(){
    let html = '';
    html += await getPlayList('0UMskgrkEH31Bpg7IRHIVZ');
    html += await getPlayList('1AcpOlHogKqQEXVn87FV8T');
    html += await getPlayList('2YgSQIE0VcJHWGJRYZplGG');
    html += await getPlayList('0H7hZ3pIPID0w3PD2x2JYf');
    html += await getPlayList('37i9dQZF1DX6t4zDdAeW2k');
    $("#spt_content").append(html);
};

const trend = async function(){

    let trend_ids = document.getElementById('trend_ids').value;
    let html = '';
    trend_ids = trend_ids.split(',');

    for(let i=0 ; i < trend_ids.length; i++){
        console.log('TRENED TRACK');
        html += await getPlayListTrend(trend_ids[i]);
    }

    $('#trend_content').html(html);
};

const ranking = async function(){

    let trend_ids = document.getElementById('ranking_ids').value;
    let html = '';
    trend_ids = trend_ids.split(',');

    for(let i=0 ; i < trend_ids.length; i++){
        html += await getPlayListRanking(trend_ids[i]);
    }

    $('#ranking_content').html(html);
};


initGeneral();
trend();
ranking();


