<!DOCTYPE html>
<html lang="en">

<head>
    <?php $MUtils = new \App\Models\MUtils(); ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/public/public_assets/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/public_assets/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/public_assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/public_assets/css/slider-radio.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/public_assets/css/datepicker.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/public_assets/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/public_assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/public_assets/css/plyr.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/public_assets/css/main.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/public_assets/skeleton/jquery.skeleton.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/public_assets/css/toastr.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/public_assets/css/custom.css">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="<?= base_url() ?>/public/public_assets/img/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="<?= base_url() ?>/public/public_assets/img/favicon-32x32.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <title><?= $MUtils->getIdentitasWeb()['identitas_web_nama']; ?></title>

</head>

<body>
    <!-- header -->
    <?php $LD = new App\Models\MLanding(); ?>
    <header class="header header--hidden">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header__content">
                        <button class="header__menu" type="button">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>

                        <a href="<?= base_url(); ?>" class="header__logo" style="width: 160px;">
                            <img src="<?= base_url() ?>/public/identitas_web_img/<?= $MUtils->getIdentitasWeb()['identitas_web_img']; ?>" alt="<?= $MUtils->getIdentitasWeb()['identitas_web_nama']; ?>">
                        </a>

                        <ul class="header__nav">
                            <li class="header__nav-item">
                                <a class="header__nav-link" href="<?= base_url(); ?>">Home</a>
                            </li>
                            <?php foreach ($LD->getMenuLanding() as $row) : ?>
                                <?php $i = $LD->checkMenuParent($row['menu_landing_id']); ?>
                                <?php if ($i == 0) : ?>
                                    <li class="header__nav-item">
                                        <a class="header__nav-link" href="<?= (substr($row['menu_landing_link'], 0, 4) == 'http') ? $row['menu_landing_link'] : base_url() . $row['menu_landing_link']; ?>"><?= $row['menu_landing_nama']; ?></a>
                                    </li>
                                <?php else : ?>
                                    <li class="header__nav-item">
                                        <a class="header__nav-link" href="<?= (substr($row['menu_landing_link'], 0, 4) == 'http') ? $row['menu_landing_link'] : base_url() . $row['menu_landing_link']; ?>" role="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?= $row['menu_landing_nama']; ?>
                                            <?php if ($row['menu_landing_nama'] != '...') : ?>
                                                <svg width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.93893 3.30334C1.08141 3.30334 0.384766 2.60669 0.384766 1.75047C0.384766 0.894254 1.08141 0.196308 1.93893 0.196308C2.79644 0.196308 3.49309 0.894254 3.49309 1.75047C3.49309 2.60669 2.79644 3.30334 1.93893 3.30334Z"></path>
                                                </svg>
                                            <?php endif; ?>
                                        </a>
                                        <ul class="dropdown-menu header__nav-menu" aria-labelledby="dropdownMenu2">
                                            <?php foreach ($LD->getMenuChild($row['menu_landing_id']) as $row) : ?>
                                                <li>
                                                    <a href="<?= (substr($row['menu_landing_link'], 0, 4) == 'http') ? $row['menu_landing_link'] : base_url() . $row['menu_landing_link']; ?>"><?= $row['menu_landing_nama']; ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </ul>

                        <div class="header__actions">
                            <form action="<?= base_url('pencarian') ?>" class="header__form" method="GET">
                                <input class="header__form-input" type="text" name="keyword" placeholder="Cari.." required>
                                <button class="header__form-btn" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z" />
                                    </svg>
                                </button>
                                <button type="button" class="header__form-close">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3345 0.000183105H5.66549C2.26791 0.000183105 0.000488281 2.43278 0.000488281 5.91618V14.0842C0.000488281 17.5709 2.26186 20.0002 5.66549 20.0002H14.3335C17.7381 20.0002 20.0005 17.5709 20.0005 14.0842V5.91618C20.0005 2.42969 17.7383 0.000183105 14.3345 0.000183105ZM5.66549 1.50018H14.3345C16.885 1.50018 18.5005 3.23515 18.5005 5.91618V14.0842C18.5005 16.7653 16.8849 18.5002 14.3335 18.5002H5.66549C3.11525 18.5002 1.50049 16.7655 1.50049 14.0842V5.91618C1.50049 3.23856 3.12083 1.50018 5.66549 1.50018ZM7.07071 7.0624C7.33701 6.79616 7.75367 6.772 8.04726 6.98988L8.13137 7.06251L9.99909 8.93062L11.8652 7.06455C12.1581 6.77166 12.6329 6.77166 12.9258 7.06455C13.1921 7.33082 13.2163 7.74748 12.9984 8.04109L12.9258 8.12521L11.0596 9.99139L12.9274 11.8595C13.2202 12.1524 13.2202 12.6273 12.9273 12.9202C12.661 13.1864 12.2443 13.2106 11.9507 12.9927L11.8666 12.9201L9.99898 11.052L8.13382 12.9172C7.84093 13.2101 7.36605 13.2101 7.07316 12.9172C6.80689 12.6509 6.78269 12.2343 7.00054 11.9407L7.07316 11.8566L8.93843 9.99128L7.0706 8.12306C6.77774 7.83013 6.77779 7.35526 7.07071 7.0624Z" />
                                    </svg>
                                </button>
                            </form>

                            <button class="header__search" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z" />
                                </svg>
                            </button>
                            <?php if (session()->get('user_id')) : ?>
                                <a href="<?= base_url('/users/' . str_encrypt(session()->get('user_id'))) ?>" class="header__user">
                                    <span><?= nickname(session()->get('user_nama')); ?></span>
                                    <i class="far fa-user"></i>
                                </a>
                            <?php else : ?>
                                <a href="<?= base_url() ?>/login" class="header__user">
                                    <span>Sign in</span>
                                    <i class="fa fa-sign-in-alt"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- end header -->

    <!-- Content Render -->
    <?= $this->renderSection('content'); ?>

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-4 col-xl-4">
                    <div class="footer__flixtv">
                        <img src="<?= base_url() ?>/public/identitas_web_img/<?= $MUtils->getIdentitasWeb()['identitas_web_img']; ?>" alt="" style="width: 220px;">
                    </div>
                    <p class="footer__tagline">
                        <?= $MUtils->getIdentitasWeb()['identitas_web_deskripsi']; ?>
                    </p>
                    <div class="footer__social">
                        <a href="<?= $MUtils->getIdentitasWeb()['identitas_web_facebook']; ?>" target="_blank">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 15C0 6.71573 6.71573 0 15 0C23.2843 0 30 6.71573 30 15C30 23.2843 23.2843 30 15 30C6.71573 30 0 23.2843 0 15Z" fill="#3B5998" />
                                <path d="M16.5634 23.8197V15.6589H18.8161L19.1147 12.8466H16.5634L16.5672 11.4391C16.5672 10.7056 16.6369 10.3126 17.6904 10.3126H19.0987V7.5H16.8457C14.1394 7.5 13.1869 8.86425 13.1869 11.1585V12.8469H11.4999V15.6592H13.1869V23.8197H16.5634Z" fill="white" />
                            </svg>
                        </a>
                        <a href="<?= $MUtils->getIdentitasWeb()['identitas_web_twitter']; ?>" target="_blank">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 15C0 6.71573 6.71573 0 15 0C23.2843 0 30 6.71573 30 15C30 23.2843 23.2843 30 15 30C6.71573 30 0 23.2843 0 15Z" fill="#55ACEE" />
                                <path d="M14.5508 12.1922L14.5822 12.7112L14.0576 12.6477C12.148 12.404 10.4798 11.5778 9.06334 10.1902L8.37085 9.50169L8.19248 10.0101C7.81477 11.1435 8.05609 12.3405 8.843 13.1455C9.26269 13.5904 9.16826 13.654 8.4443 13.3891C8.19248 13.3044 7.97215 13.2408 7.95116 13.2726C7.87772 13.3468 8.12953 14.3107 8.32888 14.692C8.60168 15.2217 9.15777 15.7407 9.76631 16.0479L10.2804 16.2915L9.67188 16.3021C9.08432 16.3021 9.06334 16.3127 9.12629 16.5351C9.33613 17.2236 10.165 17.9545 11.0883 18.2723L11.7388 18.4947L11.1723 18.8337C10.3329 19.321 9.34663 19.5964 8.36036 19.6175C7.88821 19.6281 7.5 19.6705 7.5 19.7023C7.5 19.8082 8.78005 20.4014 9.52499 20.6344C11.7598 21.3229 14.4144 21.0264 16.4079 19.8506C17.8243 19.0138 19.2408 17.3507 19.9018 15.7407C20.2585 14.8827 20.6152 13.315 20.6152 12.5629C20.6152 12.0757 20.6467 12.0121 21.2343 11.4295C21.5805 11.0906 21.9058 10.7198 21.9687 10.6139C22.0737 10.4126 22.0632 10.4126 21.5281 10.5927C20.6362 10.9105 20.5103 10.8681 20.951 10.3915C21.2762 10.0525 21.6645 9.43813 21.6645 9.25806C21.6645 9.22628 21.5071 9.27924 21.3287 9.37458C21.1398 9.4805 20.7202 9.63939 20.4054 9.73472L19.8388 9.91479L19.3247 9.56524C19.0414 9.37458 18.6427 9.16273 18.4329 9.09917C17.8978 8.95087 17.0794 8.97206 16.5967 9.14154C15.2852 9.6182 14.4563 10.8469 14.5508 12.1922Z" fill="white" />
                            </svg>
                        </a>
                        <a href="<?= $MUtils->getIdentitasWeb()['identitas_web_instagram']; ?>" target="_blank">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 15C0 6.71573 6.71573 0 15 0C23.2843 0 30 6.71573 30 15C30 23.2843 23.2843 30 15 30C6.71573 30 0 23.2843 0 15Z" fill="white" />
                                <mask id="mask0" maskUnits="userSpaceOnUse" x="0" y="0" width="30" height="30">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 15C0 6.71573 6.71573 0 15 0C23.2843 0 30 6.71573 30 15C30 23.2843 23.2843 30 15 30C6.71573 30 0 23.2843 0 15Z" fill="white" />
                                </mask>
                                <g mask="url(#mask0)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.9984 7C12.8279 7 12.5552 7.00949 11.7022 7.04834C10.8505 7.08734 10.2692 7.22217 9.76048 7.42001C9.23431 7.62433 8.78797 7.89767 8.3433 8.3425C7.8983 8.78717 7.62496 9.23352 7.41996 9.75952C7.22162 10.2684 7.08662 10.8499 7.04829 11.7012C7.01012 12.5546 7.00012 12.8274 7.00012 15.0001C7.00012 17.1728 7.00979 17.4446 7.04846 18.2979C7.08762 19.1496 7.22246 19.731 7.42013 20.2396C7.62463 20.7658 7.89796 21.2122 8.3428 21.6568C8.78731 22.1018 9.23365 22.3758 9.75948 22.5802C10.2685 22.778 10.85 22.9128 11.7015 22.9518C12.5548 22.9907 12.8273 23.0002 14.9999 23.0002C17.1727 23.0002 17.4446 22.9907 18.2979 22.9518C19.1496 22.9128 19.7316 22.778 20.2406 22.5802C20.7666 22.3758 21.2123 22.1018 21.6568 21.6568C22.1018 21.2122 22.3751 20.7658 22.5801 20.2398C22.7768 19.731 22.9118 19.1495 22.9518 18.2981C22.9901 17.4448 23.0001 17.1728 23.0001 15.0001C23.0001 12.8274 22.9901 12.5547 22.9518 11.7014C22.9118 10.8497 22.7768 10.2684 22.5801 9.7597C22.3751 9.23352 22.1018 8.78717 21.6568 8.3425C21.2118 7.89752 20.7668 7.62418 20.2401 7.42001C19.7301 7.22217 19.1484 7.08734 18.2967 7.04834C17.4434 7.00949 17.1717 7 14.9984 7ZM14.5903 8.44156L14.7343 8.44165L15.0009 8.44171C17.1369 8.44171 17.3901 8.44937 18.2336 8.4877C19.0136 8.52338 19.437 8.65369 19.719 8.76321C20.0923 8.9082 20.3585 9.08154 20.6383 9.36154C20.9183 9.64154 21.0916 9.9082 21.237 10.2816C21.3465 10.5632 21.477 10.9866 21.5125 11.7666C21.5508 12.6099 21.5591 12.8633 21.5591 14.9983C21.5591 17.1333 21.5508 17.3866 21.5125 18.23C21.4768 19.01 21.3465 19.4333 21.237 19.715C21.092 20.0883 20.9183 20.3542 20.6383 20.634C20.3583 20.914 20.0925 21.0873 19.719 21.2323C19.4373 21.3423 19.0136 21.4723 18.2336 21.508C17.3903 21.5463 17.1369 21.5547 15.0009 21.5547C12.8647 21.5547 12.6115 21.5463 11.7682 21.508C10.9882 21.472 10.5649 21.3417 10.2827 21.2322C9.90935 21.0872 9.64268 20.9138 9.36268 20.6338C9.08268 20.3538 8.90934 20.0878 8.76401 19.7143C8.65451 19.4326 8.52401 19.0093 8.48851 18.2293C8.45017 17.386 8.4425 17.1326 8.4425 14.9963C8.4425 12.8599 8.45017 12.6079 8.48851 11.7646C8.52417 10.9846 8.65451 10.5612 8.76401 10.2792C8.90901 9.90588 9.08268 9.63922 9.36268 9.35919C9.64268 9.07919 9.90935 8.90588 10.2827 8.76053C10.5647 8.65054 10.9882 8.52054 11.7682 8.48471C12.5062 8.45135 12.7922 8.44138 14.2832 8.4397V8.44171C14.3803 8.44156 14.4825 8.44153 14.5903 8.44156ZM18.3113 10.7296C18.3113 10.1994 18.7413 9.76987 19.2713 9.76987V9.76953C19.8013 9.76953 20.2313 10.1995 20.2313 10.7296C20.2313 11.2596 19.8013 11.6895 19.2713 11.6895C18.7413 11.6895 18.3113 11.2596 18.3113 10.7296ZM15.0011 10.8916C12.7323 10.8916 10.8928 12.7311 10.8928 15C10.8928 17.2688 12.7323 19.1075 15.0011 19.1075C17.27 19.1075 19.1088 17.2688 19.1088 15C19.1088 12.7311 17.2698 10.8916 15.0011 10.8916ZM17.6678 14.9999C17.6678 13.5271 16.4738 12.3333 15.0011 12.3333C13.5283 12.3333 12.3344 13.5271 12.3344 14.9999C12.3344 16.4726 13.5283 17.6666 15.0011 17.6666C16.4738 17.6666 17.6678 16.4726 17.6678 14.9999Z" fill="black" />
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-8 col-xl-8">
                    <div class="row">
                        <?php foreach ($LD->getMenuLanding('4') as $row) : ?>
                            <?php $i = $LD->checkMenuParent($row['menu_landing_id']); ?>
                            <?php if ($i == 0) : ?>
                                <div class="col-6 col-md-6 col-lg-3 col-xl-3 offset-md-2 offset-lg-0 offset-xl-1">
                                    <h6 class="footer__title"><?= $row['menu_landing_nama']; ?></h6>
                                    <div class="footer__nav">
                                        <a href="<?= (substr($row['menu_landing_link'], 0, 4) == 'http') ? $row['menu_landing_link'] : base_url() . $row['menu_landing_link']; ?>"><?= $row['menu_landing_nama']; ?></a>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="col-6 col-md-6 col-lg-3 col-xl-3 offset-md-2 offset-lg-0 offset-xl-1">
                                    <h6 class="footer__title"><?= $row['menu_landing_nama'] == '...' ? 'Tentang Kami' : $row['menu_landing_nama']; ?></h6>
                                    <div class="footer__nav">
                                        <?php foreach ($LD->getMenuChild($row['menu_landing_id']) as $row) : ?>
                                            <li>
                                                <a href="<?= (substr($row['menu_landing_link'], 0, 4) == 'http') ? $row['menu_landing_link'] : base_url() . $row['menu_landing_link']; ?>"><?= $row['menu_landing_nama']; ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="footer__content justify-content-center">
                        <small class="footer__copyright">© <?= $MUtils->getIdentitasWeb()['identitas_web_nama']; ?> 2021</small>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end footer -->

    <!-- JS -->
    <script src="<?= base_url() ?>/public/public_assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url() ?>/public/public_assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/public/public_assets/js/owl.carousel.min.js"></script>
    <script src="<?= base_url() ?>/public/public_assets/js/slider-radio.js"></script>
    <script src="<?= base_url() ?>/public/public_assets/js/select2.min.js"></script>
    <script src="<?= base_url() ?>/public/public_assets/js/datepicker.min.js"></script>
    <script src="<?= base_url() ?>/public/public_assets/js/smooth-scrollbar.js"></script>
    <script src="<?= base_url() ?>/public/public_assets/js/jquery.magnific-popup.min.js"></script>
    <script src="<?= base_url() ?>/public/public_assets/js/plyr.min.js"></script>
    <script src="<?= base_url() ?>/public/public_assets/js/main.js"></script>
    <script src="<?= base_url() ?>/public/public_assets/skeleton/jquery.scheletrone.js"></script>
    <script src="<?= base_url() ?>/public/public_assets/js/toastr.min.js"></script>
    <script src="<?= base_url() ?>/public/admin_assets/js/loadingoverlay.min.js"></script>
    <script>
        function addFavorite(t) {
            var fav = t.getAttribute('data-fav');
            var eid = t.getAttribute('data-eid');
            $.post('<?= base_url('utils/add_favorit') ?>', {
                'fav': fav,
                'eid': eid
            }, function(result, textStatus, xhr) {
                if (result.status > 0) {
                    fav == 0 ? $('button[data-eid="' + eid + '"]').attr('data-fav', '1') : $('button[data-eid="' + eid + '"]').attr('data-fav', '0');
                    fav == 0 ? $('button[data-eid="' + eid + '"]').addClass('active') : $('button[data-eid="' + eid + '"]').removeClass('active');
                    toastr.success(result.msg);
                } else {
                    window.location.replace('<?= base_url('login') ?>');
                }
            }, 'json');
        }
    </script>
    <?= $this->renderSection('custom_js'); ?>
</body>

</html>