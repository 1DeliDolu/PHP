<div class="container-fluid">
    <a class="navbar-brand" href="#" data-target="content.show" data-template="home">PROJECT</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu"
        aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="main-menu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="content.show" data-template="home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="content.show" data-template="statistics">Statistik</a>
            </li>
            <li class="nav-item">
                <?php if($this->login) : ?>
                <a class="nav-link" href="#" data-target="login.logout">Logout</a>
                <?php else : ?>
                <a class="nav-link" href="#" data-target="login.show" data-modal="true">Login</a>
                <?php endif; ?>
            </li>
        </ul>
        <form class="d-flex" role="search">
            <button id="change-theme" class="btn btn-light"><i class="bi bi-brightness-high-fill"></i></button>
        </form>
    </div>
    <script>
        $(document).ready(function () {            
            // change theme
            $('#change-theme').click((event) => {
                event.preventDefault();
                changeTheme(currentTheme == 'dark' ? 'light' : 'dark');
            });

            // click link
            $("a[data-target").click((event) => {
                // deactivate default action for hyperlinks
                event.preventDefault();
                // get data-target and call ajax event
                const modal = ($(event.target).attr("data-modal") == 'true' ? true : false) ?? false;
                // make values
                let values = {};
                let callback = callbackLoadMain;
                if($(event.target).attr("data-target") == 'login.show') {
                    callback =  modal ? callbackLoadModal : callbackLoadMain
                    values = {
                        modal: modal,
                        buttons: [
                            {
                                text: "Anmelden",
                                class: "btn btn-success",
                                click: '(event)=>{checkLogin();}'
                            },
                            {
                                text: "Registrieren",
                                class: "btn btn-link",
                                click: '(event)=>{register();}'
                            },
                            {
                                text: "Abbrechen",
                                class: "btn btn-link",
                                click: '(event)=>{closeModal();}'
                            },
                        ],
                        title: 'Anmelden'
                    };
                }else if($(event.target).attr("data-target") == 'login.logout') {
                    callback = (response) => {
                        if(response.data.success) {
                            new Ajax({
                                component:'menu.show'
                            }, null, callbackLoadMenu);
                            new Ajax({
                                component:'content.show'
                            }, null, callbackLoadMain);
                        }
                    }
                }
                // add template if exists
                if( $(event.target).attr('data-template') != undefined) {
                    values.template = $(event.target).attr("data-template");
                }
                // call ajax event
                new Ajax({
                    component: $(event.target).attr("data-target"),
                    values : values
                }, null, callback)
            });
        });
    </script>
</div>