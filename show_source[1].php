<html>
    <head>
        <meta charset="UTF-8">
        <style>
            .line{
                color:red;
            }
        </style>
    </head>
    <body>
                        <form action="" method="get">
            ディレクトリ一覧
            <select name="dir">
                <option value=../>.</option>            </select>
            <input type="submit">
        </form>
        <form>
            ファイル一覧
            <select name="file">
            <option value=m5-01.php>m5-01.php</option><option selected value=m5-02.php>m5-02.php</option>            </select>
            <input type="hidden" name="dir" value="../mission5/"> 
            <input type="submit">
        </form>
        行番号 <form name="checkform"><input type="checkbox" id="checkbox" checked></form><hr><code><span class="line">1:</span></code><code><span style="color: #000000">
&lt;!DOCTYPE&nbsp;html&gt;
</code><br />    </body>
    <script>
        let checkbox = document.getElementById('checkbox');
        checkbox.addEventListener('change', valueChange);
        function valueChange(){
            lines=document.getElementsByClassName('line')
            if((document.getElementById('checkbox').checked)){
                Array.prototype.forEach.call(lines, function(line) {
                    line.style.visibility ="visible"
                })
            }else{
                Array.prototype.forEach.call(lines, function(line) {
                    line.style.visibility ="hidden"
                })
            }
        }
        </script>
</html>