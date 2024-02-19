<?php $url = get_bloginfo('home'); ?>

	<form method="get" id="search-form" action="/">
	<input type="hidden" name="post_type" value="facility">
	<input type="hidden" class="field" name="s">

	<h3 class="common-detail-title"><i class="icon-search"></i>絞り込み検索</h3>
	<div class="area-search-box">
		<dl class="area-search-lists">
			<dt>北海道・東北</dt>
			<dd>
				<ul>
				<li><input data-region="hokkaido_tohoku" type="checkbox" name="cat_area[]" value="hokkaido" id="search-label-hokkaido"><label for="search-label-hokkaido">北海道</label></li>
				<li><input data-region="hokkaido_tohoku" type="checkbox" name="cat_area[]" value="iwate" id="search-label-iwate"><label for="search-label-iwate">岩手県</label></li>
				</ul>
			</dd>
		</dl>
		<dl class="area-search-lists">
			<dt>北陸・甲信越</dt>
			<dd>
				<ul>
				<li><input data-region="hokuriku_koshinetsu" type="checkbox" name="cat_area[]" value="niigata" id="search-label-niigata"><label for="search-label-niigata">新潟県</label></li>
				</ul>
			</dd>
		</dl>
		<dl class="area-search-lists">
			<dt>関東</dt>
			<dd>
				<ul>
				<li><input data-region="kanto" type="checkbox" name="cat_area[]" value="tokyo" id="search-label-tokyo"><label for="search-label-tokyo">東京都</label></li>
				<li><input data-region="kanto" type="checkbox" name="cat_area[]" value="kanagawa" id="search-label-kanagawa"><label for="search-label-kanagawa">神奈川県</label></li>
				<li><input data-region="kanto" type="checkbox" name="cat_area[]" value="chiba" id="search-label-chiba"><label for="search-label-chiba">千葉県</label></li>
				<li><input data-region="kanto" type="checkbox" name="cat_area[]" value="saitama" id="search-label-saitama"><label for="search-label-saitama">埼玉県</label></li>
				<li><input data-region="kanto" type="checkbox" name="cat_area[]" value="ibaraki" id="search-label-ibaraki"><label for="search-label-ibaraki">茨城県</label></li>
				<li><input data-region="kanto" type="checkbox" name="cat_area[]" value="tochigi" id="search-label-tochigi"><label for="search-label-tochigi">栃木県</label></li>
				</ul>
			</dd>
		</dl>
		<dl class="area-search-lists">
			<dt>関西</dt>
			<dd>
			<ul>
				<li><input data-region="kansai" type="checkbox" name="cat_area[]" value="osaka" id="search-label-osaka"><label for="search-label-osaka">大阪府</label></li>
				<li><input data-region="kansai" type="checkbox" name="cat_area[]" value="kyoto" id="search-label-kyoto"><label for="search-label-kyoto">京都府</label></li>
			</ul>
			</dd>
		</dl>
		<dl class="area-search-lists">
			<dt>中国・四国</dt>
			<dd>
				<ul>
				<li><input data-region="chugoku_shikoku" type="checkbox" name="cat_area[]" value="ehime" id="search-label-ehime"><label for="search-label-ehime">愛媛県</label></li>
				</ul>
			</dd>
		</dl>
		<dl class="area-search-lists">
			<dt>九州・沖縄</dt>
			<dd>
				<ul>
				<li><input data-region="kyushu_okinawa" type="checkbox" name="cat_area[]" value="kumamoto" id="search-label-kumamoto"><label for="search-label-kumamoto">熊本県</label></li>
				<li><input data-region="kyushu_okinawa" type="checkbox" name="cat_area[]" value="kagoshima" id="search-label-kagoshima"><label for="search-label-kagoshima">鹿児島県</label></li>
				<li><input data-region="kyushu_okinawa" type="checkbox" name="cat_area[]" value="okinawa" id="search-label-okinawa"><label for="search-label-okinawa">沖縄県</label></li>
				</ul>
			</dd>
		</dl>
	</div>

	<div class="area-search-box">
		<dl class="featured-words">
			<dt>タグ一覧</dt>
			<dd>
				<ul>
				<li><input type="checkbox" name="post_tag[]" value="urban" id="search-label-urban"><label for="search-label-urban">#都市型</label></li>
				<li><input type="checkbox" name="post_tag[]" value="resort" id="search-label-resort"><label for="search-label-resort">#リゾート</label></li>
				<li><input type="checkbox" name="post_tag[]" value="golf" id="search-label-golf"><label for="search-label-golf">#ゴルフ場隣接</label></li>
				<li><input type="checkbox" name="post_tag[]" value="near-terminal" id="search-label-near-terminal"><label for="search-label-near-terminal">#駅直結</label></li>
				<li><input type="checkbox" name="post_tag[]" value="near_station_5min" id="search-label-near_station_5min"><label for="search-label-near_station_5min">#最寄駅から徒歩5分以内</label></li>
				<li><input type="checkbox" name="post_tag[]" value="near_station_10min" id="search-label-near_station_10min"><label for="search-label-near_station_10min">#最寄駅から徒歩10分以内</label></li>
				<li><input type="checkbox" name="post_tag[]" value="360" id="search-label-360"><label for="search-label-360">#360°パノラマビュー</label></li>
				</ul>
			</dd>
		</dl>
	</div>

	<div class="btn-area">
		<p class="btn-normal"><button class="is_disabled" type="submit" data-submit-button="" disabled="disabled"><span id="count_wrap"></span>絞り込む</button></p>
	</div>

	</form>





<script>
$(function(){

	$('form#search-form input').click(function() {
		var getParamStr = '/?' + $('form#search-form').serialize();
		/*console.log(getParamStr);*/
		$.ajax({
			url: getParamStr,    // 表示させたいコンテンツがあるページURL
		        cache: false,
	        	datatype: 'html',
		        success: function(html) {
				var h = $(html).find('#facility-search-result-count').text();    // 表示させたいコンテンツの要素を指定
				if(h == '') {
					console.log(h);
					$('#count_wrap').text('');
					$('p.btn-normal button').prop('disabled', true).addClass('is_disabled');
				} else {
					var h = h + '件ヒット ';
					$('#count_wrap').text(h);
					$('p.btn-normal button').prop('disabled', false).removeClass('is_disabled');
				}
        console.log(h)
			},
			error: function (e) {
        console.log(e)
				$('#count_wrap').text('');
				$('p.btn-normal button').prop('disabled', true).addClass('is_disabled');
			}
		});
	})

});
</script>

<style>

</style>
