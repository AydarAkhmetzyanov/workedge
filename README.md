USERS

companymembership
rights
0 - не состоит в компании
1-29 - гость
30-49 - фрилансер
50-99 - сотрудник
100-149 - менеджер
150-199 - администратор
200-240 - владелец

TASKS
status
1 не смотрел
2 в процессе
3 завершено еба

LinkType
0 - компания

TASKSMEMBERSHIP
role
1 создтель
2 ответственный
3 участник

edited libs
bootstrap date picker
translation


https://github.com/valums/file-uploader
client.js

fix
_upload: function(id, params){
        this._options.onUpload(id, this.getName(id), true);

        var file = this._files[id],
            name = this.getName(id),
            size = this.getSize(id);

        this._loaded[id] = 0;

        var xhr = this._xhrs[id] = new XMLHttpRequest();
        var self = this;

        xhr.upload.onprogress = function(e){
            if (e.lengthComputable){
                self._loaded[id] = e.loaded;
                self._options.onProgress(id, name, e.loaded, e.total);
            }
        };

        xhr.onreadystatechange = function(){
            if (xhr.readyState == 4){
                self._onComplete(id, xhr);
            }
        };

        // build query string
        params = params || {};
        params[this._options.inputName] = name;
        var queryString = qq.obj2url(params, this._options.action);

        var protocol = this._options.demoMode ? "GET" : "POST";
        xhr.open(protocol, this._options.action+'/'+name, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.setRequestHeader("X-File-Name", encodeURIComponent(name));
        if (this._options.forceMultipart) {
            var formData = new FormData();
            formData.append(this._options.inputName, file);
            file = formData;
        } else {
            xhr.setRequestHeader("Content-Type", "application/octet-stream");
            //NOTE: return mime type in xhr works on chrome 16.0.9 firefox 11.0a2
            xhr.setRequestHeader("X-Mime-Type",file.type );
        }
        for (key in this._options.customHeaders){
            xhr.setRequestHeader(key, this._options.customHeaders[key]);
        };
        xhr.send(file);
    }
	
server.php
full new, dont update)