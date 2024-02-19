	<footer class="l-footer">
		<a href="#" class="pagetop">PAGE TOP</a>
		<div class="l-wrapper">
			<?php
			?>
			<?php if( !is_circulareeconomy() ): ?>
				<?php //　施設詳細画面の場合 ?>
				<?php if ( is_singular('facility') ): ?>
					<?php get_template_part("var/column-relate-facility"); ?>
					<?php
						$footer_consult = get_post_meta($post->ID, 'footer_consult', true);
						if ( $footer_consult && $footer_consult[0] == '「専門家に相談する」を表示する') :
					?>
					<div class="consultation">
						<div class="consultation__image">
							<img src="/co-mit_renew_201910/img/consultation-bg.jpg" alt="">
						</div>
						<div class="consultation__contents">
							<h2 class="consultation__heading"><i></i>施設探しでお悩みの方は、<br class="sp-only">お気軽にご相談ください</h2>
							<p class="consultation__text pc-only">ご担当者さまの負担を軽減し、本来の業務に専念できるよう、専門家に相談できるサービスもございます。<br class="sp-only">目的やご要望を伺い、施設のご提案から宿泊、研修会場まで手配いたしますので、お気軽にご相談ください。</p>
							<a href="/consult/" class="button button--lg">無料で専門家に相談する</a>
						</div>
					</div>
					<?php endif; ?>
					<?php get_template_part("var/column-pickup_jinji"); ?>
				
				<?php // 施設一覧画面の場合 ?>
				<?php elseif (is_post_type_archive("facility") || is_tax('area')) : ?>
					<?php get_template_part("var/column-ranking-facility"); ?>
					<?php if ( is_tax('area', 'kanto') || is_tax('area', 'kansai') || is_tax('area', 'tokyo') || is_tax('area', 'chiba') || is_tax('area', 'kanagawa') || is_tax('area', 'osaka')) : ?>
						<?php $args = ['terms' => $term, 'term_name' => single_term_title( '', false ) ]; ?>
						<?php get_template_part("var/column-faq-facility", null, $args); ?>
					<?php elseif (is_search()) : ?>
						<?php if(isset($_GET['cat_area'])): ?>
							<?php $cat_array = $_GET['cat_area']; ?>
						<?php else: ?>
							<?php $cat_array = ""; ?>
						<?php endif; ?>
						<?php $cat_area = ""; ?>
						<?php if( is_array($cat_array)): ?>
							<?php if( count($cat_array) == 1): ?>
								<?php $cat_area = $cat_array[0]; ?>
							<?php endif; ?>
						<?php else: ?>
							<?php $cat_area = $cat_array; ?>
						<?php endif; ?>
	
						<?php if($cat_area == 'kanto' || $cat_area == 'kansai' || $cat_area == 'tokyo' || $cat_area == 'chiba' || $cat_area == 'kanagawa' || $cat_area == 'osaka'): ?>
							<?php $args = ['terms' => $cat_area, 'term_name' => get_term_by('slug',$cat_area,"area")->name]; ?>
							<?php get_template_part("var/column-faq-facility", null, $args); ?>
						<?php endif; ?>
					<?php endif; ?>
					<div class="consultation">
						<div class="consultation__image">
							<img src="/co-mit_renew_201910/img/consultation-bg.jpg" alt="">
						</div>
						<div class="consultation__contents">
							<h2 class="consultation__heading"><i></i>施設探しでお悩みの方は、<br class="sp-only">お気軽にご相談ください</h2>
							<p class="consultation__text pc-only">ご担当者さまの負担を軽減し、本来の業務に専念できるよう、専門家に相談できるサービスもございます。<br class="sp-only">目的やご要望を伺い、施設のご提案から宿泊、研修会場まで手配いたしますので、お気軽にご相談ください。</p>
							<a href="/consult/" class="button button--lg">無料で専門家に相談する</a>
						</div>
					</div>
					<?php get_template_part("var/column-pickup_jinji"); ?>      
				<?php else: ?>
				<div class="consultation">
					<div class="consultation__image">
						<img src="/co-mit_renew_201910/img/consultation-bg.jpg" alt="">
					</div>
					<div class="consultation__contents">
						<h2 class="consultation__heading"><i></i>施設探しでお悩みの方は、<br class="sp-only">お気軽にご相談ください</h2>
						<p class="consultation__text pc-only">ご担当者さまの負担を軽減し、本来の業務に専念できるよう、専門家に相談できるサービスもございます。<br class="sp-only">目的やご要望を伺い、施設のご提案から宿泊、研修会場まで手配いたしますので、お気軽にご相談ください。</p>
						<a href="/consult/" class="button button--lg">無料で専門家に相談する</a>
					</div>
				</div>
				<?php endif; ?>
		</div>
		<div class="l-wrapper">
				<div class="l-pc-2col">
					<div>
						<p class="footer-h3 footer-h3--tag f_accordion__title">タグから施設を探す</p>
						<div class="f_accordion__content">
							<dl class="footer-tag-list">
								<dt class="footer-tag__head">■主旨</dt>
								<dd class="footer-tag__content">
									<ul class="footer-tag__detail">
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=exective">幹部研修</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=new-member">新入社員研修</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=offsite">オフサイトミーティング</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=team-build">チームビルディング</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=dev-camp">開発合宿</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=long-training">長期研修</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=training-voice">声出し研修</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=hierarchy">階層別研修</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=theme">テーマ別研修</a></li>
									</ul>
								</dd>
							</dl>
							<dl class="footer-tag-list">
								<dt class="footer-tag__head">■立地</dt>
								<dd class="footer-tag__content">
									<ul class="footer-tag__detail">
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=resort">リゾート</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=near_station">駅近</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=good-access">都内からのアクセス良い</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=sea">海</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=mountain">山</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=lake">湖</a></li>
									</ul>
								</dd>
							</dl>
							<dl class="footer-tag-list">
								<dt class="footer-tag__head">■会場</dt>
								<dd class="footer-tag__content">
									<ul class="footer-tag__detail">
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=many-people">大人数可</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=window">窓付き会議室</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=variation">会場バリエーション豊富</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=3m">会場天井3ｍ以上</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=360">360°パノラマビュー</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=video">動画</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=barrier-free">バリアフリー対応可</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=fashionable">おしゃれ</a></li>
									</ul>
								</dd>
							</dl>
							<dl class="footer-tag-list">
								<dt class="footer-tag__head">■ソフト</dt>
								<dd class="footer-tag__content">
									<ul class="footer-tag__detail">
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=chartered">貸切可能</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=include-training">研修パックあり</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=pro-staff">専門スタッフ</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=free-transfer">無料送迎あり</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=halal-muslim">ハラール・ムスリム相談可</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=meal-arrangement">食事アレンジ可</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=allergy">アレルギー対応</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=meeting-package">ミーティングパッケージあり</a></li>
									</ul>
								</dd>
							</dl>
							<dl class="footer-tag-list">
								<dt class="footer-tag__head">■アトラクション</dt>
								<dd class="footer-tag__content">
									<ul class="footer-tag__detail">
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=outdoor">アウトドア</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=activity">アクティビティ</a></li>
									</ul>
								</dd>
							</dl>
							<dl class="footer-tag-list">
								<dt class="footer-tag__head">■付帯サービス</dt>
								<dd class="footer-tag__content">
									<ul class="footer-tag__detail">
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=sightseeing">観光</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=hot-spring">大浴場・温泉</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=golf">ゴルフ場隣接</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=ground">グラウンド</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=gym">体育館</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=bbq">BBQ</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=parking">駐車場</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=laundry">ランドリー</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=fitness">フィットネス</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=pool">プール</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=shop">売店・コンビニあり</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=takibi">焚き火</a></li>
										<li><a href="/?post_type=facility&s=&facility_capa=&facility_fee=&post_tag%5B%5D=sauna">サウナ</a></li>
									</ul>
								</dd>
							</dl>
						</div>
					</div>
					<div>
						<p class="footer-h3 footer-h3--area f_accordion__title">エリアから探す</p>
						<div class="f_accordion__content">
							<dl class="area-1">
								<dt class="area-1__head"><a href="/area/hokkaido_tohoku/">北海道・東北エリア</a></dt>
								<dd class="area-1__content">
									<ul class="area-1__detail">
										<li><a href="/area/hokkaido_tohoku/hokkaido/">北海道</a></li>
										<li><a href="/area/hokkaido_tohoku/iwate/">岩手県</a></li>
										<li><a href="/area/hokkaido_tohoku/miyagi/">宮城県</a></li>
									</ul>
								</dd>
							</dl>
							<dl class="area-1">
								<dt class="area-1__head"><a href="/area/hokuriku_koshinetsu/">北陸・甲信越エリア</a></dt>
								<dd class="area-1__content">
									<ul class="area-1__detail">
										<li><a href="/area/hokuriku_koshinetsu/niigata/">新潟県</a></li>
									</ul>
								</dd>
							</dl>
							<dl class="area-1">
								<dt class="area-1__head"><a href="/area/kanto/">関東エリア</a></dt>
								<dd class="area-1__content">
									<ul class="area-1__detail">
										<li><a href="/area/kanto/tokyo/">東京都</a></li>
										<li><a href="/area/kanto/kanagawa/">神奈川県</a></li>
										<li><a href="/area/kanto/chiba/">千葉県</a></li>
										<li><a href="/area/kanto/saitama/">埼玉県</a></li>
										<li><a href="/area/kanto/ibaraki/">茨城県</a></li>
										<li><a href="/area/kanto/tochigi/">栃木県</a></li>
										<li><a href="/area/kanto/gunma/">群馬県</a></li>
									</ul>
								</dd>
							</dl>
							<dl class="area-1">
								<dt class="area-1__head"><a href="/area/chubu_tokai/">中部・東海エリア</a></dt>
								<dd class="area-1__content">
									<ul class="area-1__detail">
										<li><a href="/area/chubu_tokai/yamanashi/">山梨県</a></li>
										<li><a href="/area/chubu_tokai/shizuoka/">静岡県</a></li>
										<li><a href="/area/chubu_tokai/nagano/">長野県</a></li>
										<li><a href="/area/chubu_tokai/aichi/">愛知県</a></li>
										<li><a href="/area/chubu_tokai/mie/">三重県</a></li>
									</ul>
								</dd>
							</dl>

							<dl class="area-1">
								<dt class="area-1__head"><a href="/area/kansai/">関西エリア</a></dt>
								<dd class="area-1__content">
									<ul class="area-1__detail">
										<li><a href="/area/kansai/osaka/">大阪府</a></li>
										<li><a href="/area/kansai/kyoto/">京都府</a></li>
										<li><a href="/area/kansai/hyogo/">兵庫県</a></li>
										<li><a href="/area/kansai/shiga/">滋賀県</a></li>
										<li><a href="/area/kansai/wakayama/">和歌山県</a></li>
									</ul>
								</dd>
							</dl>
							<dl class="area-1">
								<dt class="area-1__head"><a href="/area/chugoku_shikoku/">中国・四国エリア</a></dt>
								<dd class="area-1__content">
									<ul class="area-1__detail">
										<li><a href="/area/chugoku_shikoku/hiroshima/">広島県</a></li>
										<li><a href="/area/chugoku_shikoku/ehime/">愛媛県</a></li>
									</ul>
								</dd>
							</dl>
							<dl class="area-1">
								<dt class="area-1__head"><a href="/area/kyushu_okinawa/">九州・沖縄エリア</a></dt>
								<dd class="area-1__content">
									<ul class="area-1__detail">
										<li><a href="/area/kyushu_okinawa/fukuoka/">福岡県</a></li>
										<li><a href="/area/kyushu_okinawa/kumamoto/">熊本県</a></li>
										<li><a href="/area/kyushu_okinawa/kagoshima/">鹿児島県</a></li>
										<li><a href="/area/kyushu_okinawa/okinawa/">沖縄県</a></li>
									</ul>
								</dd>
							</dl>
						</div>
						<p class="footer-h3 footer-h3--purpose f_accordion__title">目的から探す</p>
						<div class="f_accordion__content">
							<ul class="purpose-1">
								<li class="purpose-1__item">
									<a href="/purpose/concent/">集中できる環境で研修したい</a>
									<span class="sp-only">新入社員研修・資格取得トレーニング・技術講座</span>
								</li>
								<li class="purpose-1__item">
									<a href="/purpose/motivate/">モチベーションが上がる環境で研修したい</a>
									<span class="sp-only">マネジメント研修・コーチング研修・役員研修</span>
								</li>
								<li class="purpose-1__item">
									<a href="/purpose/environment/">いつもと違った環境で研修したい</a>
									<span class="sp-only">プロジェクトミーティング・ビジョンメイキング合宿・開発合宿</span>
								</li>
								<li class="purpose-1__item">
									<a href="/purpose/incentive/">インセンティブ旅行を兼ねて研修したい</a>
									<span class="sp-only">オフサイトミーティング・チームビルディング・ワーケーション　など</span>
								</li>
							</ul>
						</div>
					</div>
				</div>	
			<?php endif; ?>
		</div>
	<div class="footer">
		<div class="l-wrapper">
			<div class="pc-only">
			<div class="footer-top">
				<div class="pc-5col">
					<div class="footer-logo">
						<p><a href="/">研修・合宿施設検索サイト | <br>CO-MIT(コミット)</a></p>
						<a href="/" class="footer-logo__image"><img src="/co-mit_renew_201910/img/logo_white.png" srcset="/co-mit_renew_201910/img/logo_white.png 1x, /co-mit_renew_201910/img/logo_white@2x.png 2x" alt="CO-MIT"></a>
					</div>
					<ul class="sns">
						<li>SNS</li>
						<li class="sns__item"><a href="https://www.facebook.com/kensyu.comit/" target="_blank"><img src="/co-mit_renew_201910/img/icon_facebook.png" alt="facebook"></a></li>

						<li class="sns__item sns__icon-youtube"><a href="https://www.youtube.com/channel/UChVGwQOstm2VFPvBZVng8VA" target="_blank"><img src="/co-mit_renew_201910/img/icon_youtube.jpg" alt="youtube"></a></li>
					</ul>

				</div>
				<div class="pc-5col">
					<p class="footer-menu__title">施設を探している方</p>
					<ul class="footer-menu">
						<li><a href="/facility/">施設を探す</a></li>
						<li><a href="/consult/">専門家に相談する</a></li>
						<li><a href="/#hotel-type">宿タイプから探す</a></li>							
					</ul>
				</div>
				<div class="pc-5col">
				<p class="footer-menu__title">情報収集している方</p>
					<ul class="footer-menu">
						<li><a href="/column/">研修ノウハウ・コラム</a></li>
						<li><a href="/workation-portal/">ワーケーションポータル</a></li>
						<li><a href="/offsite/">オフサイト研修のススメ</a></li>							
						<li><a href="/events/">イベントに参加する</a></li>							
						<li><a href="/circulareconomy/">サーキュラーエコノミーを知る</a></li>							
					</ul>
				</div>
				<div class="pc-5col">
				<p class="footer-menu__title">ご利用ガイド</p>
					<ul class="footer-menu">
						<li><a href="/beginner/">初めての方はこちら</a></li>
						<li><a href="/about/">CO-MITの強み</a></li>
						<li><a href="/faq/">よくある質問</a></li>							
						<li><a href="/contact/">掲載に関する問い合わせ</a></li>							
					</ul>
				</div>
				<div class="pc-5col">
				<p class="footer-menu__title">CO-MITについて</p>
					<ul class="footer-menu">
						<li><a href="/agreement/">利用規約</a></li>
						<li><a href="/disclaimer/">免責事項</a></li>
						<li><a href="https://asno-sys.co.jp/privacy/" target="_blank">個人情報保護方針</a></li>							
						<li><a href="https://asno-sys.co.jp/" target="_blank">運営会社</a></li>							
					</ul>
				</div>
			</div>
			</div>
		</div>
		<div class="footer-top sp-only">
			<div class="footer-logo">
				<a href="/" class="footer-logo__image"><img src="/co-mit_renew_201910/img/logo_white.png" srcset="/co-mit_renew_201910/img/logo_white.png 1x, /co-mit_renew_201910/img/logo_white@2x.png 2x" alt="CO-MIT"></a>
				<p><a href="/">研修・合宿施設検索サイト | CO-MIT(コミット)</a></p>
			</div>
			<ul class="footer-menu">
				<li><a href="/beginner/">初めての方はこちら</a></li>
				<li><a href="/facility/">施設を探す</a></li>
				<li><a href="/workation-portal/">ワーケーションポータル</a></li>
				<li><a href="/offsite/">オフサイト研修のススメ</a></li>							
				<li><a href="/circulareconomy/">サーキュラーエコノミーを知る</a></li>							
				<li><a href="/column/">研修ノウハウ・コラム</a></li>
				<li><a href="/consult/">専門家に相談する</a></li>
				<li><a href="/faq/">よくある質問</a></li>							
			</ul>
		</div>
		<div class="l-wrapper">
			<div class="footer-bottom">
				<ul class="banners">
					<li class="banners__item"><a href="https://www.kaigishitu.com/" target="_blank"><img src="/co-mit_renew_201910/img/bnr_kaigishitsu.png" alt="会議室.com"></a></li>
					<li class="banners__item"><a href="https://www.kaigishitu.com/meeting-hacks/" target="_blank"><img src="/co-mit_renew_201910/img/bnr_kaigihack.png" alt="会議HACK"></a></li>
					<li class="banners__item"><a href="https://www.rental-o.com/" target="_blank"><img src="/co-mit_renew_201910/img/bnr_rentaloffice.png" alt="レンタルオフィス.com"></a></li>
					<li class="banners__item"><a href="https://hospitality-agent.co.jp/" target="_blank"><img src="/co-mit_renew_201910/img/bnr_ha.png" alt="hospitality agent"></a></li>
				</ul>
				<div class="sp-only">
					<ul class="sns">
						<li class="sns__item"><a href="https://www.facebook.com/kensyu.comit/" target="_blank"><img src="/co-mit_renew_201910/img/icon_facebook.png" alt="facebook"></a></li>

						<li class="sns__item sns__icon-youtube"><a href="https://www.youtube.com/channel/UChVGwQOstm2VFPvBZVng8VA" target="_blank"><img src="/co-mit_renew_201910/img/icon_youtube.jpg" alt="youtube"></a></li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	<p class="copyright">Copyright (C) ASNO SYSTEM All Rights Reserved.</p>
</div>


<script src="/co-mit_renew_201910/js/jquery-2.2.4.min.js"></script>
<script src="/co-mit_renew_201910/js/js.cookie.min.js"></script>
<?php if(is_home() || is_front_page()) : ?>
<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
<?php endif; ?>

<script>
(function ($) {
$(function(){
	$('form#search-form input, form#search-form select').change(function(e) {
    console.log(this)
		var getParamStr = '/?' + $('form#search-form').serialize();
		console.log(getParamStr);
		$.ajax({
			url: getParamStr,    // 表示させたいコンテンツがあるページURL
		        cache: false,
	        	datatype: 'html',
		        success: function(html) {
				var h = $(html).find('#facility-search-result-count').text();    // 表示させたいコンテンツの要素を指定
				if(h == '') {
					$('#count_wrap').text('');
					$('#hit_count').prop('disabled', true).addClass('js-disabled');
				} else {
					h += '件ヒット ';
					$('#count_wrap').text(h);
					$('#hit_count').prop('disabled', false).removeClass('js-disabled');
				}
        console.log(h);
			},
			error: function () {
				$('#count_wrap').text('');
				$('#hit_count').prop('disabled', true).addClass('js-disabled');
			}
		});
	})

	$('[data-accordion-open]').on('click', function(){
		$(this).parents('.btn-area').fadeOut('fast');
		$('[data-accordion]').slideDown('fast');
	});

});
})(jQuery);
</script>

<?php if ( is_singular('facility') ) : ?>
<script>
	$(window).on("load", function () {
		$(".fancybox-youtube").fancybox({
			youtube : {
				controls : 0,
				showinfo : 0
			}
		})
	});
</script>
<?php endif; ?>

<?php if ( is_single("column") ) : ?>
<script>
	if ( $('.list-box__heading') ) {
		var headingText = $('.list-box__heading').text();
		$('.list-box__heading').text('')
		$('.list-box__heading').append('<span>' + headingText + '</span>');
	}
</script>
<?php endif; ?>


<?php if ( is_search() ) : ?>
<script type="text/javascript">
$(function() {
	var url = location.protocol + "//" + location.host + location.pathname + location.search;
	var params = url.split('?');
	var paramms = params.length>1&&params[1].split('&');
	var paramArray = [];
	for(var i = 0; i < paramms.length; i++) {
		var vl = paramms[i].split('=');
		paramArray.push(vl[0]);
		paramArray[vl[0]] = vl[1];
		var terms = decodeURIComponent(vl[1]);
		// console.log(vl)

		$('input').each(function(){
			var val = $(this).val();
			if(terms === val) {
				$(this).prop("checked",true);
			}
		});

		if ( (vl[0] === "facility_capa" || vl[0] === "facility_fee") && vl[1]) {
			console.log($(".search-ui-wrapper select option[value='"+vl[1]+"']"))
			var tgt = ".search-ui-wrapper select option[value='"+vl[1]+"']";
			if ($(tgt).length) {
				$(tgt).prop("selected", true);
			}
		}

		/*トップから遷移した場合のエリアをチェック状態にする */
		if(vl[0] == 'cat_area%5B%5D'){
			var cat_area = vl[1];
			var elm = $("input[data-region=" + cat_area + "]");
			elm.each(function(indx) {
					$(this).prop('checked', true);
			});
		}
	}

	/*絞り込み条件がある時に条件をひらいておく */
	var conditions = $("div.search-box__detail");
	conditions.each(function(indx) {
		if( $(this).find("input:checked").length ){
			$(this).find("div.search-box__detail__head").addClass("is-opend");
			$(this).find("div.search-box__detail__content").css("display","block");
		}
	});


});
</script>
<?php endif; ?>


<?php if (is_page('favorite')) :?>
<script defer>
	(function(){
		// まとめてチェック
		$(window).on('load',function(){
			$('.js-check-target,.js-all-check').prop('checked',false);
		});
		$('.js-all-check').on('click',function(){
			if ( $(this).prop('checked') == true ) {
				$('.js-check-target').prop('checked',true);
			} else {
				$('.js-check-target').prop('checked',false);
			}
		});
		//チェックしたものを削除
		$('.js-check-delete').on('click',function(){
			var confirm = window.confirm('検討リストから外してもよろしいでしょうか？');
			if ( confirm == true ){
				var favoriteList = Cookies.get('co-mitFavoriteList');
				var favoriteListParesed = [];
				if (favoriteList) {
					favoriteListParesed = JSON.parse(Cookies.get('co-mitFavoriteList'));
				}
				var targetFacilityId = [];

				$('.js-check-target').each(function(){
					if ( $(this).prop('checked') == true ){
						var thisFacilityId = $(this).attr('data-facility-id');
						targetFacilityId.push(thisFacilityId);
					}
				});

				if ( targetFacilityId ) {
					for ( var i = 0; i < favoriteListParesed.length; i++ ){
						for ( var j = 0; j < targetFacilityId.length; j++ ){
							if ( favoriteListParesed[i] == targetFacilityId[j] || favoriteListParesed[i] == null || favoriteListParesed[i] == undefined ) {
								favoriteListParesed.splice(i,1);
								i--;
								break;
							}
						}
					}
				}
				Cookies.set('co-mitFavoriteList', JSON.stringify(favoriteListParesed), { expires: 365 });

				location.reload();
			}
		});
	}());

</script>
<?php endif; ?>

<?php if (is_page('about')) :?>
<script>
function autoHeight( targetElm , column ){
  var target = $(targetElm),
      maxHeight = 0,
      targetHeight = 0,
      targetCounter = target.length,
      targetItems = [];
  target.each(function(){
    $(this).css('height','auto');

    targetHeight = $(this).height();
    if( targetHeight > maxHeight ){
        maxHeight = targetHeight;
    }

    targetItems.push($(this));

    if (targetItems.length == column) {
        targetItems.forEach(function(i){
        i.css('height',maxHeight)
        });
        maxHeight = 0;
        targetHeight = 0;
        targetItems = [];
    }
    targetCounter--;

    if (targetCounter == 0) {
        targetItems.forEach(function(i){
        i.css('height',maxHeight)
        });
    }
  });
}
$(window).on('load resize',function(){
	autoHeight('.js-autoheight',3)
	autoHeight('.js-autoheight2',3)
});
</script>

<?php endif; ?>
<script>
	$(function () {
		var HREF = "/?post_type=facility&s=";
		var $pullDown = $(".js-pulldown-filter");

		$pullDown.each(function () {
			$(this).on("change", function () {
				var str;
				var $root = $(this).closest(".js-pulldown-filter");
				var arr = [];
				var $items = $root.find("option:selected");

				$items.each(function () {
					if (!$(this).val()) {
						arr.push("");
					} else {
						var pref = $(this).closest("select").hasClass("search__select--area") ? "cat_area=" : "facility_capa=";
						arr.push(pref + $(this).val());
					}
				});

				var q = arr.join("&");

				if (q == "&") {
					str = "/facility/";
				} else {
					str =  HREF + "&" + q;
				}

				if ($root.find(".button--search").length) {
					$root.find(".button--search").attr("href", str);
				} else {
					$root.find(".button--sm-search").attr("href", str);
				}
			});
		})

	});
</script>

<?php if( !(is_tax('feature')) ): ?>
<script type="text/javascript">
$(function() {
	// $('#refine_btn a').click(function() {
	// 	$('#refine_box').slideToggle("fast",function(){
		<?php if( !isset($term) ): ?>
			<?php $taxonomy = $wp_query->get_queried_object();?>
			<?php if (is_tax('area')): ?>
				<?php if($taxonomy->parent == 0): ?>
					var elm = $("input[data-region='<?php echo $term; ?>']");
					elm.each(function(indx) {
						if( indx == elm.length - 1 ){
							$(this).trigger('click');
						} else {
							$(this).prop('checked', true);
						}
					});
				<?php else: ?>
				if( $('input#search-label-<?php echo $term; ?>:not(:checked)') ) {
					$('input#search-label-<?php echo $term; ?>').trigger('click');
				}
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
	// 	});
	// })
});
</script>
<?php endif; ?>

<?php if (is_tax('feature')): ?>
<script type="text/javascript">
$(function() {
	var $tgt = $('input#search-label-<?php echo $term; ?>').trigger('click');
  var $root = $tgt.closest(".search-box__detail");
  $tgt.parent().closest(".search-box__detail__content").show();
  $root.find(".search-box__detail__head").addClass("is-opend");
  // .find(".search-box__detail__head a").trigger("click");
});
</script>
<?php endif; ?>

<?php /*if ( is_single() && $post->post_parent ) :*/ ?>
<?php /*if ( get_field('edit_type') === 'アクセス・周辺情報' )  :*/ ?><?php /*
<script src="//pkg.navitime.co.jp/resources/js/iframeResizer.min.js"></script>
<script type="text/javascript">

	(function(src) {
		var el = document.createElement("iframe");
		el.src = src
		el.id = "navitime-package";
		el.scrolling = "no";
		el.width = "100%";
		el.style = "overflow: hidden;border-style:none;"

		var $el = $(el);

		$("#navitime-loader").append(el);
		$el.load(function(){
			$el.iFrameResize({checkOrigin: false});
		});
		setTimeout(function () {
			//iframe先ページロード中にも対応
			$el.triggerHandler("load");
		}, 200)

	}("<?php echo get_field('navitime_url'); ?>"))
</script>*/ ?>
<?php /*endif;*/ ?>
<?php /*endif;*/ ?>

<?php if ( is_singular('facility') )  : ?>
<!-- facility page only -->
<script src="/co-mit_renew_201910/js/facility.js"></script>
<?php endif; ?>
<script src="/co-mit_renew_201910/js/swiper.min.js"></script>
<script src="/co-mit_renew_201910/js/ofi.min.js"></script>
<?php if (is_singular('facility')): ?>
<script src="/co-mit_renew_201910/js/jquery.fancybox.min.js"></script>
<script type="text/javascript">
$(function() {
// accordion
	$('[data-accordion-open]').on('click', function(){
		$(this).parents('.btn-area').fadeOut('fast');
		$('[data-accordion]').slideDown('fast');
	});
// accordion02
	$('[data-accordion02-open]').on('click', function(){
		$('.js-line-hidden').css('border-bottom','none');
		$(this).parents('.btn-area').fadeOut('fast');
		$('[data-accordion02]').slideDown('fast');
	});
// accordion03
	$('[data-accordion03-open]').on('click', function(){
		$('.js-line-hidden tr:last-child th, .js-line-hidden tr:last-child td').css('border-bottom','1px solid #D6D7D7');
		$(this).parents('.btn-area').fadeOut('fast');
		$('[data-accordion03]').slideDown('fast');
	});
});
</script>
<?php endif; ?>
<?php
// 一覧ページ
if (
  (is_post_type_archive('facility') ||
  is_archive('area') ||
  is_archive('feature') ||
  is_archive('puprpose')) && !is_post_type_archive("column")
): ?>
<script src="/co-mit_renew_201910/js/jquery.fancybox.min.js"></script>
<?php endif; ?>
<script type="text/javascript">
    //アコーディオンをクリックした時の動作
  $('.accordion__title').on('click', function() {
    var findElm = $(this).next(".accordion__content");
    $(findElm).slideToggle();//アコーディオンの上下動作

    if($(this).hasClass('is-open')){
      $(this).removeClass('is-open');
    }else{//それ以外は
      $(this).addClass('is-open');
    }
  });

</script>
<script src="/co-mit_renew_201910/js/common.js"></script>

<?php wp_footer(); ?>


<?php
// ナビプラスレコメンド　コラム配下ページとそれ以外で共通連携スクリプトタグの出し分け
if (get_post_type() === 'column'): ?>
<script type="text/javascript" src="//r6.snva.jp/javascripts/reco/2/sna.js?k=45MRqaLbm9B2t"></script>
<?php else: ?>
<script type="text/javascript" src="//r6.snva.jp/javascripts/reco/2/sna.js?k=O1Dq8VN3M8QBH"></script>
<?php endif; ?>

<?php
// コラムページの閲覧ビーコン
if ( is_singular('column') ): ?>
<script type="text/javascript">
  __snahost = "r6.snva.jp";
  recoConstructer({
    k:"45MRqaLbm9B2t",
    bcon:{
      basic:{
        items:[{id:<?php echo '"', get_post( get_the_ID() )->post_name, '"'; ?>
}]
      }
    }
  });
</script>
<?php endif; ?>

<?php
// 施設ページの閲覧ビーコン
if ( is_singular('facility') ): ?>
<script type="text/javascript">
__snahost = "r6.snva.jp";
recoConstructer({
	k:"O1Dq8VN3M8QBH",
	bcon:{
		basic:{
			items:[{id:<?php $parent_id = $post->post_parent; if ( isset($parent_id) ){ echo '"', get_post_field( 'post_name', $parent_id ), '"'; } else { echo '"', get_post( get_the_ID() )->post_name, '"'; } ?>}]
		}
	}
});
</script>
<?php endif; ?>

<?php
// タクソノミーの取得
$obj = get_queried_object();
if(isset($obj->taxonomy)){
  $taxonomy = $obj->taxonomy;
}else{
  $taxonomy = "";
}
// 施設一覧ページのrecoConstructer用
if (is_post_type_archive("facility") || is_tax('area') || is_post_type_archive("column") || ($taxonomy == "category_column") || ($taxonomy == "tag_column")) : ?>
<script type="text/javascript">
__snahost = "r6.snva.jp";
recoConstructer({});
</script>
<?php endif; ?>
<?php if( is_circulareeconomy() ): ?>
	<script src="/co-mit_renew_201910/js/circular-common.js"></script>
<?php endif;?>

</body>
</html>