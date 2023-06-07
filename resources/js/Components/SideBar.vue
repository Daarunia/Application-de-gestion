<template>
    <div id="sidebar">
        <header>
            <a href="#">Douane Express</a>
        </header>
        <ul class="nav flex-column">
            <li>
                <a href="#">
                    Services
                </a>
            </li>
            <li>
                <a href="#">
                    Commandes
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'SideBar',
    props: {
        name: String,
    },
};
</script>

<style>
#sidebar {
    z-index: 1000;
    position: fixed;
    left: 250px;
    width: 250px;
    height: 100%;
    margin-left: -250px;
    overflow-y: auto;
    background: #37474F;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#sidebar header {
    font-size: 20px;
    line-height: 52px;
    text-align: center;
}

#sidebar header a {
    color: #fff;
    display: block;
    text-decoration: none;
}

#sidebar header li:hover {
    color: #fff;
}

#sidebar .nav a {
    background: none;
    color: #CFD8DC;
    font-size: 14px;
    padding: 16px 24px;
    text-decoration: none;
}

#sidebar .nav a:hover {
    background: none;
    color: #ECEFF1;
}

#sidebar .nav a i {
    margin-right: 16px;
}
</style>
