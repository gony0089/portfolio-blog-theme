

let currentPage = 1;
// 現在選択されているカテゴリーIDを記憶しておく変数（0は「すべて」）
let currentCategoryId = 0; 
let isFetching = false; // 連続クリックを防止するためのフラグ

const categoryButtons = document.querySelectorAll('.category-box a');
const loadMoreButton = document.querySelector('.load-more-button'); 
const postContainer = document.querySelector(".article-list-container");


// --- カテゴリーボタンのクリック処理 ---
categoryButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        event.preventDefault();
         const postsContainer = document.querySelector(".article-sub-container");
         postsContainer.scrollIntoView({ behavior: 'smooth' });
        
        // 状態をリセット
        currentPage = 1; 
        currentCategoryId = event.currentTarget.dataset.categoryId;
        
        // 記事一覧をクリアして、新しいカテゴリーの記事を1ページ目から取得
        fetchPosts(); 
    });
});


// --- 「もっと見る」ボタンのクリック処理 ---
if (loadMoreButton) {
    loadMoreButton.addEventListener('click', () => {
        // 次のページ番号をリクエスト
        currentPage++; 
        fetchPosts();
    });
}


// --- 記事を取得して表示する共通の関数 ---
function fetchPosts() {
    // 既に読み込み中の場合は、処理を中断
    if (isFetching) {
        return;
    }
    isFetching = true; // 読み込み開始のフラグを立てる

    // カスタムAPIエンドポイントのURL
    const apiEndpoint = `/wp-json/my-custom-api/v1/posts?category=${currentCategoryId}&page=${currentPage}`;

    fetch(apiEndpoint)
        .then(response => response.json())
        .then(posts => {
            // 読み込みが完了したのでフラグを下ろす
            isFetching = false;

            // もし返ってきた記事が0件だったら
            if (posts.length === 0) {
                loadMoreButton.style.display = 'none'; // ボタンを非表示にする
                return; // 処理を終了
            }

            // 新しい記事のHTMLを組み立てる
            let newHTML = '';
            posts.forEach(post => {
                newHTML += `
                    <article class="article-item">
                        <a href="${post.link}" class="article-item__link">
                            <div class="article-item-thumbnail">
                                <img src="${post.thumbnail}" alt="">
                            </div>
                            <div class="article-item-info">
                                <h3 class="article-item-title">${post.title}</h3>
                                <span class="article-days">day:${post.date}</span>
                            </div>
                        </a>
                    </article>
                `;
            });

            // 1ページ目の場合は中身を入れ替え、2ページ目以降は末尾に追記
            if (currentPage === 1) {
                postContainer.innerHTML = newHTML;
            } else {
                postContainer.insertAdjacentHTML('beforeend', newHTML);
            }

            // 挿入後に .article-list-container の直下に残る <p> 要素を削除
            // （もっと見る押下後に空の <p> が先頭に来てしまう問題の対処）
            Array.from(postContainer.children).forEach(child => {
                if (child.tagName && child.tagName.toLowerCase() === 'p') {
                    // 空の p または改行だけの p を削除
                    if (child.textContent.trim() === '') {
                        child.remove();
                    }
                }
            });

            // もし返ってきた記事が9件未満なら、それが最後のページなのでボタンを隠す
            // (9はfunctions.phpで指定したposts_per_pageの数)
            if (posts.length < 9) {
                loadMoreButton.style.display = 'none';
            } else {
                loadMoreButton.style.display = 'block'; // 次のページがある可能性があるので表示
            }
        })
        .catch(error => {
            console.error(error);
            isFetching = false; // エラー時もフラグを下ろす
        });
}



//picuparticle-seiper

	document.addEventListener('DOMContentLoaded', function () {
		 const initialSlidesPerView = window.innerWidth >= 760 ? 3 : 2;
		const swiper = new Swiper('.my-pickup-swiper', {
			loop: true,
			spaceBetween: 15,
			slidesPerView: initialSlidesPerView,

			autoplay:{
				delay:2000,
				disableOnInteration: false,
			},
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			
		});
		 let isDesktop = window.innerWidth >= 760;
    
    window.addEventListener('resize', function() {
        const nowDesktop = window.innerWidth >= 760;
        
        if (isDesktop !== nowDesktop) {
            isDesktop = nowDesktop;
            
            // パラメータを直接変更
            swiper.params.slidesPerView = isDesktop ? 3 : 2;
            swiper.update();
            swiper.autoplay.start(); 
        }
    });
	});


	
