<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>バナ管理理画面</title>
        @vite('resources/css/app.css')
    </head>
    <body>
        {{-- 共通ヘッダーを読み込み --}}
        @include('admin.layouts.app')

        <main>
            <div class="admin-banner-edit-body">
                <div class="back-btn">
                    {{-- 戻るボタン --}}
                    <a href="{{ route('admin.show.top') }}">←戻る</a>
                </div>

            <h2>バナー管理</h2>
            
            <div>


                {{-- 画像追加表示エリア --}}
                <div id="imageContainer"></div>

                                {{-- 追加アイコン --}}
                <img class="icon-plus" src="{{ asset('images/icon-plus.png') }}" alt="追加" id="addImageBtn">
            </div>
            <script>
                const deleteIconUrl = "{{ asset('images/icon-minus.png') }}";

                const container = document.getElementById('imageContainer');
                const addImageBtn = document.getElementById('addImageBtn');

                // ページロード時にローカルストレージから復元
                window.addEventListener('load', () => {
                    const storedImages = JSON.parse(localStorage.getItem('uploadedImages') || '[]');
                    storedImages.forEach(base64Image => {
                        addImagePreview(base64Image);
                    });
                });

                // 画像プレビュー＋削除アイコン作成関数
                function addImagePreview(base64Image) {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('image-wrapper');

                    const preview = document.createElement('img');
                    preview.classList.add('image-preview');
                    preview.src = base64Image;
                    preview.style.display = 'inline-block';

                    // ファイル選択inputを追加（非表示にする場合）
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'images[]';
                    fileInput.accept = 'image/*';
                    fileInput.style.display = 'inline-block'; 

                    const deleteIcon = document.createElement('img');
                    deleteIcon.src = deleteIconUrl;
                    deleteIcon.alt = '削除';
                    deleteIcon.title = '削除';
                    deleteIcon.classList.add('icon-minus');
                    deleteIcon.addEventListener('click', () => {
                        wrapper.remove();
                        removeImageFromStorage(base64Image);
                    });

                    wrapper.appendChild(preview);
                    wrapper.appendChild(fileInput);
                    wrapper.appendChild(deleteIcon);
                    container.appendChild(wrapper);
                }
                // ローカルストレージから画像を削除する関数
                function removeImageFromStorage(base64Image) {
                    let storedImages = JSON.parse(localStorage.getItem('uploadedImages') || '[]');
                    storedImages = storedImages.filter(img => img !== base64Image);
                    localStorage.setItem('uploadedImages', JSON.stringify(storedImages));
                }

                // 「＋」ボタン押下時の処理
                addImageBtn.addEventListener('click', () => {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('image-wrapper');

                    // プレビュー用img
                    const preview = document.createElement('img');
                    preview.classList.add('image-preview');
                    preview.style.display = 'none';

                    // ファイル選択input
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'images[]';
                    fileInput.accept = 'image/*';

                    fileInput.addEventListener('change', function () {
                        const file = this.files[0];
                        if (!file) return;

                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const base64 = e.target.result;

                            // プレビューに表示
                            preview.src = base64;
                            preview.style.display = 'inline-block';

                            // ローカルストレージに保存
                            let storedImages = JSON.parse(localStorage.getItem('uploadedImages') || '[]');
                            storedImages.push(base64);
                            localStorage.setItem('uploadedImages', JSON.stringify(storedImages));
                        };
                        reader.readAsDataURL(file);

                        // 入力値リセットしないと連続選択できない
                        this.value = '';
                    });

                    // 削除アイコン
                    const deleteIcon = document.createElement('img');
                    deleteIcon.src = deleteIconUrl;
                    deleteIcon.alt = '削除';
                    deleteIcon.title = '削除';
                    deleteIcon.classList.add('icon-minus');
                    deleteIcon.addEventListener('click', () => {
                        wrapper.remove();
                        if(preview.src) removeImageFromStorage(preview.src);
                    });

                    wrapper.appendChild(preview);
                    wrapper.appendChild(fileInput);
                    wrapper.appendChild(deleteIcon);
                    container.appendChild(wrapper);
                });
            </script>
        </main>
    </body>
</html>

