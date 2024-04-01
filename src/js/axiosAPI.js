const axiosLib = async (url, data = {}, option = "") => {
    const dataParams = new URLSearchParams();

    Object.keys(data).forEach(key => {
        dataParams.append(key, data[key]);
    });

    dataParams.append("option", option);

    //https://ss1.xrea.com/isym.s223.xrea.com/
    var result = await axios.post(`${url}`, dataParams);

    if(result.status != 200){
        app.modalChange("データベース接続エラー", "5000-0001", "データベースへの接続に失敗しました。しばらくしてから、再読み込みしてください。", "");
    }else{
        result = result.data;
    
    
        if(result.type == "error") {
            app.modalChange(result.data.title, result.data.code, result.data.message, result.data.url);
        }
    }

    return result;
}