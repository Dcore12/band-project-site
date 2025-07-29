<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="description"
      content="Suicide Silence official fan site - explore albums, band members, upcoming tours and exclusive merchandise."
    />
    <meta
      name="keywords"
      content="Suicide Silence, Deathcore, Tours, The Cleansing, No Time to Bleed, The Black Crown, You Can't Stop Me, Become the Hunter, Remember... You Must Die, Chris Garza, Mark Heylmun, Dan Kenny, Eddie Hermida, Ernie Iniguez"
    />
    <meta name="author" content="Duarte Santos" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="CSS/style.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Orbitron&family=Staatliches&family=Teko&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Orbitron&family=Staatliches&family=Teko&display=swap"
      rel="stylesheet"
    />

    <title>Suicide Silence - Discography, Members & Tours</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="data:," />
  </head>
  <body class="p-3 m-0 border-0 bd-example m-0 border-0">
    <!-- Header -->
    <div class="bg">
  <div class="top-links" style="text-align: right">
    <?php if (isset($_SESSION['user'])): ?>
        <span class="user-info">
            👤 <a href="include/profile.php" style="text-decoration: none"><?= htmlspecialchars($_SESSION['user']['full_name'] ?: $_SESSION['user']['username']) ?></a>
            <?php if ($_SESSION['user']['is_admin']): ?>
                <a href="include/admin.php">
                <span class="admin-badge">(admin)</span></a>
            <?php endif; ?>
        </span>
        <a href="include/logout.php" class="logout-btn">
            <i class="fa fa-sign-out"></i> Logout
        </a>
    <?php else: ?>
        <a href="include/login.php" class="login-btn">
            <i class="fa fa-sign-in"></i> Login
        </a>
    <?php endif; ?>
    <a href="#register" class="cart-link">Register</a>
    <a href="include/cart_items.php" class="cart-link">
        <i class="fa fa-shopping-cart"></i>
        <span id="cart-count">
            <?= isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0 ?>
        </span>
    </a>
</div>

      <br />
      <nav class="navbar bg-dark border border-body" data-bs-theme="dark">
        <div class="container-fluid">
          <a
            class="navbar-brand"
            href="https://en.wikipedia.org/wiki/Suicide_Silence"
            target="_blank"
            ><img
              src="Imagens/Logo/suicide-silence-52a7b29eb5339.png"
              alt="Logo_Suicide_Silence"
              style="width: 100px; height: auto"
          /></a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item dropdown"></li>
              <li class="nav-item">
                <a class="nav-link" href="#aboutus">About us</a>
              </li>

              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  Discography
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="#discography"
                      >The Cleansing (2007)</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="#discography"
                      >No Time to Bleed (2009)</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="#discography"
                      >The Black Crown (2011)</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="#discography"
                      >You Can't Stop Me (2014)</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="#discography"
                      >Suicide Silence (2017)</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="#discography"
                      >Become the Hunter (2020)</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="#discography"
                      >Remember... You Must Die (2023)</a
                    >
                  </li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                  >Members</a
                >
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="#members">Chris Garza</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#members">Mark Heylmun</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#members">Dan Kenny</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="members"
                      >Hernan "Eddie" Hermida</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="#members">Ernie Iniguez</a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#tours">Tours</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#merch">Merchandise</a>
              </li>
            </ul>

            <form class="d-flex" role="search">
              <input
                class="form-control me-2"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <button
                class="btn btn-outline-danger btn-metal"
                type="submit"
                style="border-radius: 10px 0 10px 0"
              >
                Search
              </button>
            </form>
          </div>
        </div>
      </nav>

      <img
        src="Imagens/20221209_suicide_silence__header.webp"
        class="img-fluid"
        alt="header_suicide_silence"
      />
    </div>
    <br />
    <!-- BOTÂO AUDIO-->
    <div id="audio">
      <audio controls>
        <source
          src="Audio/07.%20You%20Can%27t%20Stop%20Me.mp3"
          type="audio/mpeg"
        />
        <p class="text-danger">
          Seu navegador não suporta o elemento de áudio.
        </p>
      </audio>
      <p
        class="text-center mt-2"
        style="
          font-family: 'Orbitron', sans-serif;
          color: #dc3545;
          letter-spacing: 1px;
        "
      >
        NOW PLAYING: YOU CAN'T STOP ME
      </p>
    </div>
    <br />
    <!-- About us -->
    <div class="bg">
      <h1 id="aboutus">
        <img src="Imagens/Icons/hand_.jpg" alt="hand" width="25" /> About us
        <img src="Imagens/Icons/hand_.jpg" alt="hand" width="25" />
      </h1>
      <div
        id="carouselExampleInterval"
        class="carousel slide"
        data-bs-ride="carousel"
      >
        <div class="carousel-inner">
          <div class="carousel-item active" data-bs-interval="10000">
            <img
              src="Imagens/Band/Suicide_Silence_-_Rock_am_Ring_2017-AL3048.jpg"
              class="d-block w-100"
              alt="band1"
            />
          </div>
          <div class="carousel-item" data-bs-interval="2000">
            <img
              src="Imagens/Band/suicide-silence-album-2016-dean-karr-82.jpg"
              class="d-block w-100"
              alt="band2"
            />
          </div>
          <div class="carousel-item" data-bs-interval="3000">
            <img
              src="Imagens/Band/Suicide-Silence.webp"
              class="d-block w-100"
              alt="band3"
            />
          </div>
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#carouselExampleInterval"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#carouselExampleInterval"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <hr />
      <div class="about-band py-5">
        <div class="container">
          <div class="row g-4">
            <!-- Coluna 1 -->
            <div class="col-12 col-md-4">
              <div class="band-column p-3">
                <p>
                  <strong>Suicide Silence</strong> erupted from the shadows of
                  Riverside, California in 2002. Since then, they've carved
                  their legacy in bone and steel, delivering seven full-length
                  albums, three EPs, and nearly twenty brutal music videos.
                </p>
              </div>
            </div>

            <!-- Coluna 2 -->
            <div class="col-12 col-md-4">
              <div class="band-column p-3">
                <p>
                  <strong>Deathcore is their weapon</strong> — a violent fusion
                  of Death Metal and Metalcore soaked in Black Metal, Grindcore,
                  and Groove Metal.
                </p>
                <p>
                  Razor-sharp speed changes, chaotic time signatures, guttural
                  growls and shrieks tear through every track.
                </p>
              </div>
            </div>

            <!-- Coluna 3 -->
            <div class="col-12 col-md-4">
              <div class="band-column p-3">
                <p>
                  From the experimentation of
                  <strong>The Black Crown</strong> to the pure Nu Metal punch of
                  their self-titled album,
                  <strong>Suicide Silence</strong> refuses to be chained.
                </p>
                <p>
                  2020's <strong>Become the Hunter</strong> brought them back to
                  their brutal roots.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="btn_merch">
        <a
          href="https://en.wikipedia.org/wiki/Suicide_Silence"
          target="_blank"
          class="btn btn-outline-danger btn-metal getticket"
          style="border-radius: 10px 0 10px 0"
        >
          Read more
        </a>
      </div>
    </div>
    <br />
    <!-- Discography -->
    <div class="bg">
      <h1 id="discography">
        <img src="Imagens/Icons/hand_.jpg" alt="hand" width="25" />
        Discography
        <img src="Imagens/Icons/hand_.jpg" alt="hand" width="25" />
      </h1>
      <br />
      <div class="divbody">
        <input type="radio" name="position" checked />
        <input type="radio" name="position" />
        <input type="radio" name="position" />
        <input type="radio" name="position" />
        <input type="radio" name="position" />
        <input type="radio" name="position" />
        <input type="radio" name="position" />
        <main id="carousel">
          <div class="item">
            <div>
              <img
                src="Imagens/Albuns/Suicide_Silence_-_The_Cleansing.jpg"
                class="img_carousel"
                alt="The_Cleansing"
              />
            </div>
            <div>
              <p class="parag_alb">
                The Cleansing<br />
                (2007)
              </p>
              <div>
                <h6 class="songs">
                  Revelations (Intro) | Unanswered | Hands of a Killer | The
                  Price of Beauty | The Fallen | No Pity for a Coward | The
                  Disease | Bludgeoned to Death | Girl of Glass | In a
                  Photograph | Eyes Sewn Shut | Green Monster | Destruction of a
                  Statue (hidden track)
                </h6>
              </div>
            </div>
          </div>
          <div class="item">
            <div>
              <img
                src="Imagens/Albuns/No_Time_to_Bleed_high-res.jpg"
                class="img_carousel"
                alt="No_Time_to_Bleed"
              />
            </div>
            <div>
              <p class="parag_alb">No Time To Bleed (2009)</p>
              <div>
                <h6 class="songs">
                  Wake Up | Lifted | Smoke | Something Invisible | No Time to
                  Bleed | Suffer | ...And Then She Bled | Wasted | Your
                  Creations | Genocide | Disengage
                </h6>
              </div>
            </div>
          </div>
          <div class="item">
            <div>
              <img
                src="Imagens/Albuns/SS_The_Black_Crown.jpg"
                class="img_carousel"
                alt="The_Black_Crown"
              />
            </div>
            <div>
              <p class="parag_alb">The Black Crown <br />(2011)</p>
              <div>
                <h6 class="songs">
                  Slaves to Substance | O.C.D. | Human Violence | You Only Live
                  Once | Fuck Everything | March to the Black Crown | Witness
                  the Addiction | Cross-Eyed Catastrophe | Smashed | The Only
                  Thing That Sets Us Apart | Cancerous Skies
                </h6>
              </div>
            </div>
          </div>
          <div class="item">
            <div>
              <img
                src="Imagens/Albuns/You_Can't_Stop_Me_(Suicide_Silence).jpg"
                class="img_carousel"
                alt="You_Can't_Stop_Me"
              />
            </div>
            <div>
              <p class="parag_alb">You Can't Stop Me (2014)</p>
              <div>
                <h6 class="songs">
                  M.A.L. (instrumental) | Inherit the Crown | Cease to Exist |
                  Sacred Words | Control | Warrior | You Can't Stop Me | Monster
                  Within | We Have All Had Enough | Ending Is the Beginning |
                  Don't Die | Ouroboros
                </h6>
              </div>
            </div>
          </div>
          <div class="item">
            <div>
              <img
                src="Imagens/Albuns/SuicideSilence2017.jpg"
                class="img_carousel"
                alt="Suicide_Silence"
              />
            </div>
            <div>
              <p class="parag_alb">Suicide Silence <br />(2017)</p>
              <div>
                <h6 class="songs">
                  Doris | Silence | Listen | Dying in a Red Room | Hold Me Up,
                  Hold Me Down | Run | The Zero | Conformity | Don't Be Careful
                  You Might Hurt Yourself
                </h6>
              </div>
            </div>
          </div>
          <div class="item">
            <div>
              <img
                src="Imagens/Albuns/Become_the_Hunter.jpg"
                class="img_carousel"
                alt="Become_the_Hunter"
              />
            </div>
            <div>
              <p class="parag_alb">Become The Hunter (2020)</p>
              <div>
                <h6 class="songs">
                  Meltdown (instrumental) | Two Steps | Feel Alive | Love Me to
                  Death | In Hiding | Death's Anxiety | Skin Tight | The Scythe
                  | Serene Obscene | Disaster Valley | Become the Hunter
                </h6>
              </div>
            </div>
          </div>
          <div class="item">
            <div>
              <img
                src="Imagens/Albuns/SuicideSilenceRYMD.jpg"
                class="img_carousel"
                alt="RYMD"
              />
            </div>
            <div>
              <p class="parag_alb">Remember... You Must Die (2023)</p>
              <div>
                <h6 class="songs">
                  Remember... | You Must Die | Capable of Violence (N.F.W.) |
                  Fucked for Life | Kill Forever | God Be Damned | Alter of Self
                  | Endless Dark | The Third Death | Be Deceived | Dying Life |
                  Full Void
                </h6>
              </div>
            </div>
          </div>
        </main>
      </div>
      <div>
        <h6 style="color: white" id="albuns">
          <a
            href="https://en.wikipedia.org/wiki/The_Cleansing_(Suicide_Silence_album)"
            target="_blank"
            >The Cleansing</a
          >
          |
          <a
            href="https://en.wikipedia.org/wiki/No_Time_to_Bleed"
            target="_blank"
            >No time to bleed</a
          >
          |
          <a
            href="https://en.wikipedia.org/wiki/The_Black_Crown"
            target="_blank"
            >The Black Crown</a
          >
          |
          <a
            href="https://en.wikipedia.org/wiki/You_Can%27t_Stop_Me_(album)"
            target="_blank"
            >You Can't Stop Me</a
          >
          |
          <a
            href="https://en.wikipedia.org/wiki/Suicide_Silence_(album)"
            target="_blank"
            >Suicide Silence</a
          >
          |
          <a
            href="https://en.wikipedia.org/wiki/Become_the_Hunter"
            target="_blank"
            >Become The Hunter</a
          >
          |
          <a
            href="https://en.wikipedia.org/wiki/Remember..._You_Must_Die"
            target="_blank"
            >Remember... You Must Die</a
          >
        </h6>
      </div>
    </div>
    <br />
    <!-- Members -->
    <div class="bg">
      <h1 id="members">
        <img src="Imagens/Icons/hand_.jpg" alt="hand" width="25" />
        Members
        <img src="Imagens/Icons/hand_.jpg" alt="hand" width="25" />
      </h1>
      <div class="container my-5">
        <div class="row justify-content-center" id="membersList">
          <div class="col-md-2 m-2 card member-card">
            <img
              src="Imagens/Membros/Chris-garza-suicide-silence.webp"
              class="card-img-top"
              alt="Chris Garza"
            />
            <div class="card-body text-center">
              <strong>Chris Garza</strong><br />
              Rhythm guitar
            </div>
            <div class="bio">
              Chris Garza is a founding member and rhythm guitarist of Suicide
              Silence, active since 2002. He's known for his heavy riffs and
              stage presence.
            </div>
          </div>

          <div class="col-md-2 m-2 card member-card">
            <img
              src="Imagens/Membros/Daniel.jpg"
              class="card-img-top"
              alt="Dan Kenny"
            />
            <div class="card-body text-center">
              <strong>Dan Kenny</strong><br />
              Bass
            </div>
            <div class="bio">
              Dan Kenny has been the bassist for Suicide Silence since 2008. His
              deep basslines are a core part of the band's sound.
            </div>
          </div>

          <div class="col-md-2 m-2 card member-card">
            <img
              src="Imagens/Membros/Eddie.JPG"
              class="card-img-top"
              alt="Eddie Hermida"
            />
            <div class="card-body text-center">
              <strong>Eddie Hermida</strong><br />
              Vocals
            </div>
            <div class="bio">
              Hernan 'Eddie' Hermida became the lead vocalist of Suicide Silence
              in 2013, following the death of
              <a
                href="https://en.wikipedia.org/wiki/Mitch_Lucker"
                target="_blank"
                class="mitch-link"
                data-bs-toggle="popover"
                data-bs-trigger="hover focus"
                title="Mitch Lucker (1984-2012)"
                data-bs-content="Founding vocalist of Suicide Silence. His legacy lives on."
                data-bs-img="Imagens/Membros/Mitch.jpg"
              >
                Mitch Lucker</a
              >. He brings intense vocals and strong energy to the stage.
            </div>
          </div>

          <div class="col-md-2 m-2 card member-card">
            <img
              src="Imagens/Membros/Ernie1.jpg"
              class="card-img-top"
              alt="Ernie Iniguez"
            />
            <div class="card-body text-center">
              <strong>Ernie Iniguez</strong><br />
              Drums
            </div>
            <div class="bio">
              Ernie Iniguez joined Suicide Silence as the drummer in 2022. His
              precise and aggressive drumming drives the band's powerful sound.
            </div>
          </div>

          <div class="col-md-2 m-2 card member-card">
            <img
              src="Imagens/Membros/Mark.jpg"
              class="card-img-top"
              alt="Mark Heylmun"
            />
            <div class="card-body text-center">
              <strong>Mark Heylmun</strong><br />
              Lead guitar
            </div>
            <div class="bio">
              Mark Heylmun has been the lead guitarist of Suicide Silence since
              2005. His solos and brutal riffs are iconic within the deathcore
              scene.
            </div>
          </div>
        </div>
      </div>

      <br />
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-4 mb-4">
            <a
              href="https://pt.wikipedia.org/wiki/Hernan_%22Eddie%22_Hermida"
              class="btn btn-outline-danger w-100 getticket"
              style="border-radius: 10px 0 10px 0"
              target="_blank"
            >
              <div class="d-flex flex-column">
                <div class="p-2">Hernan "Eddie" Hermida</div>
                <div class="p-2">Lead vocals (2013-present)</div>
              </div>
            </a>
          </div>

          <div class="col-md-4 mb-4">
            <a
              href="https://www.google.com/search?q=suicide+silence+chris+garza"
              class="btn btn-outline-danger w-100 getticket"
              style="border-radius: 10px 0 10px 0"
              target="_blank"
            >
              <div class="d-flex flex-column">
                <div class="p-2">Chris Garza</div>
                <div class="p-2">Rhythm guitar (2002-present)</div>
              </div>
            </a>
          </div>

          <div class="col-md-4 mb-4">
            <a
              href="https://www.google.com/search?q=suicide+silence+daniel+kenny"
              class="btn btn-outline-danger w-100 getticket"
              style="border-radius: 10px 0 10px 0"
              target="_blank"
            >
              <div class="d-flex flex-column">
                <div class="p-2">Daniel Kenny</div>
                <div class="p-2">Bass (2009-present)</div>
              </div>
            </a>
          </div>

          <div class="col-md-4 mb-4">
            <a
              href="https://www.google.com/search?q=suicide+silence+mark+heylmun"
              class="btn btn-outline-danger w-100 getticket"
              style="border-radius: 10px 0 10px 0"
              target="_blank"
            >
              <div class="d-flex flex-column">
                <div class="p-2">Mark Heylmun</div>
                <div class="p-2">Lead guitar (2005-present)</div>
              </div>
            </a>
          </div>

          <div class="col-md-4 mb-4">
            <a
              href="https://www.google.com/search?q=suicide+silence+ernie+iniguez"
              class="btn btn-outline-danger w-100 getticket"
              style="border-radius: 10px 0 10px 0"
              target="_blank"
            >
              <div class="d-flex flex-column">
                <div class="p-2">Ernie Iniguez</div>
                <div class="p-2">Drums (2022-present)</div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>

    <br />
    <!-- Tours -->

    <div class="bg">
      <h1 id="tours">
        <img src="Imagens/Icons/hand_.jpg" alt="hand" width="25" /> TOURS
        <img src="Imagens/Icons/hand_.jpg" alt="hand" width="25" />
      </h1>
      <br />
      <div class="timeline-container container">
        <!-- Events will be injected here by JS -->
      </div>
    </div>

    <br />
    <!-- Merch -->
    <div class="bg">
      <h1 id="merch">
        <img src="Imagens/Icons/hand_.jpg" alt="hand" width="25" />
        Merchandise
        <img src="Imagens/Icons/hand_.jpg" alt="hand" width="25" />
      </h1>

      <!-- Filtro de categorias -->
      <section id="filter-section" class="container mt-5">
        <h3 style="color: white">Filter by Category</h3>
        <select id="category-filter" class="form-select">
          <option value="">All Categories</option>
        </select>
      </section>

      <section class="container mt-4">
        <div
          class="row justify-content-center row-cols-1 row-cols-md-3 g-4"
          id="product-list"
        ></div>
      </section>

      <!-- Formulário de cálculo de valor -->
      <section class="container mt-5">
        <h3 style="color: white">Calculate Total Value</h3>
        <form id="calc-form" class="row g-3">
          <div class="col-md-6">
            <label for="product" class="form-label">Select a product:</label>
            <select id="product" name="product" class="form-select"></select>
          </div>
          <div class="col-md-6">
            <label for="quantity" class="form-label">Quantity:</label>
            <input
              type="number"
              id="quantity"
              name="quantity"
              class="form-control"
              min="1"
              value="1"
            />
          </div>
          <div class="col-12">
            <button
              type="button"
              id="calculate"
              class="btn btn-outline-danger btn-metal getticket"
              style="border-radius: 10px 0 10px 0"
            >
              Calculate Value
            </button>
          </div>
        </form>
        <div id="total-value" class="alert alert-total mt-3 d-none"></div>
      </section>

      <!-- Lightbox -->
      <div id="lightbox" class="lightbox" style="display: none">
        <div class="lightbox-content bg-white p-4 border rounded">
          <span class="close-btn" style="cursor: pointer; float: right"
            >&times;</span
          >
          <h2 id="lightbox-title"></h2>
          <img
            id="lightbox-image"
            src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
            class="img-fluid"
            alt=""
          />
          <p id="lightbox-description"></p>
          <p><strong id="lightbox-price"></strong></p>
        </div>
      </div>

      <br />
      <div class="btn_merch">
        <a
          href="https://www.unkind.pt/pt/catalogo/musica/suicide-silence/?srsltid=AfmBOooxML_-Ixn2pxymSoSm6_aMW-7M02mMu5renXAKz1BY2vvmFqPq"
          target="_blank"
          class="btn btn-outline-danger btn-metal getticket"
          style="border-radius: 10px 0 10px 0"
        >
          Click for more Merch
        </a>
      </div>
    </div>
    <br />

    <!-- Formulário de Registo -->
    <div class="bg">
      <h1 id="register">
        <img src="Imagens/Icons/hand_.jpg" alt="hand" width="25" />
        Register
        <img src="Imagens/Icons/hand_.jpg" alt="hand" width="25" />
      </h1>

      <img
        src="Imagens/Logo/suicide-silence-52a7b273c866f_.png"
        alt="logo_sub"
        class="logo_sub"
        style="width: 300px; height: auto"
      />

      <form id="registerForm" class="row g-3" enctype="multipart/form-data">
        <div class="col-md-6">
          <label for="inputUsername" class="form-label">User Name</label>
          <input
            type="text"
            class="form-control"
            id="inputUsername"
            name="username"
            required
          />
        </div>

        <div class="col-md-6">
          <label for="inputName" class="form-label">Full Name</label>
          <input
            type="text"
            class="form-control"
            id="inputName"
            name="fullname"
            required
          />
        </div>

        <div class="col-md-6">
          <label for="inputBirthdate" class="form-label">Date of Birth</label>
          <input
            type="date"
            class="form-control"
            id="inputBirthdate"
            name="birthdate"
            required
          />
        </div>

        <div class="col-md-6">
          <label for="inputEmail" class="form-label">Email</label>
          <input
            type="email"
            class="form-control"
            id="inputEmail"
            name="email"
            required
          />
        </div>

        <div class="col-md-6">
          <label for="inputPassword" class="form-label">Password</label>
          <input
            type="password"
            class="form-control"
            id="inputPassword"
            name="password"
            required
          />
        </div>

        <div class="col-md-6">
          <label for="inputConfirmPassword" class="form-label"
            >Confirm Password</label
          >
          <input
            type="password"
            class="form-control"
            id="inputConfirmPassword"
            name="confirm_password"
            required
          />
        </div>

        <div class="col-md-6">
          <label for="inputUserType" class="form-label">User Type</label>
          <select class="form-select" id="inputUserType" name="role" required>
            <option value="" selected disabled>Choose...</option>
            <option value="User">User</option>
            <option value="Administrator">Administrator</option>
          </select>
        </div>

        <div class="col-md-6">
          <label for="inputProfilePic" class="form-label"
            >Profile Picture</label
          >
          <input
            type="file"
            class="form-control"
            id="inputProfilePic"
            name="profile_image"
            accept="image/*"
            required
          />
        </div>

        <div class="col-12">
          <label for="inputMessage" class="form-label">Message</label>
          <textarea
            class="form-control"
            id="inputMessage"
            name="message"
            rows="4"
            required
          ></textarea>
        </div>

        <div class="btn_merch d-flex justify-content-center gap-3 mt-4">
          <button
            type="submit"
            class="btn btn-outline-danger btn-metal"
            style="border-radius: 10px 0 10px 0"
          >
            Register
          </button>
          <button
            type="button"
            id="unsubscribeBtn"
            class="btn btn-outline-danger btn-metal"
            style="display: none; border-radius: 10px 0 10px 0"
          >
            Unsubscribe
          </button>
        </div>
      </form>

      <div
        id="successMessage"
        class="alert alert-success text-center mt-4 d-none"
      >
        <i class="fa fa-check" aria-hidden="true"></i>
        Registration successful! Redirecting...
      </div>
    </div>

    <br />
    <!-- Footer -->
    <div class="bg">
      <div class="footer">
        <p>
          <a href="https://www.instagram.com/suicidesilence/" target="_blank"
            ><i
              class="fa fa-instagram"
              aria-hidden="true"
              style="font-size: 28px"
            ></i
          ></a>
          <a
            href="https://www.facebook.com/suicidesilence/?locale=pt_PT"
            target="_blank"
            ><i
              class="fa fa-facebook-square"
              aria-hidden="true"
              style="font-size: 28px"
            ></i
          ></a>
          <a href="https://www.youtube.com/user/suicidesilence" target="_blank"
            ><i
              class="fa fa-youtube-play"
              aria-hidden="true"
              style="font-size: 28px"
            ></i
          ></a>
          <a
            href="https://open.spotify.com/artist/6HZr7Fs2VfV1PYHIwo8Ylc"
            target="_blank"
            ><i
              class="fa fa-spotify"
              aria-hidden="true"
              style="font-size: 28px"
            ></i
          ></a>
          <a href="https://x.com/suicidesilence" target="_blank"
            ><i
              class="fa fa-twitter-square"
              aria-hidden="true"
              style="font-size: 28px"
            ></i
          ></a>
          <a
            href="https://music.apple.com/us/artist/suicide-silence/181915332"
            target="_blank"
            ><i
              class="fa fa-apple"
              aria-hidden="true"
              style="font-size: 28px"
            ></i
          ></a>
        </p>
        <footer>
          &copy; 2025 Powered by
          <a href="mailto:duarte.n.santos@gmail.com" id="mail" target="_blank"
            >Suicide Silence</a
          >
        </footer>
      </div>
    </div>
    <button
      onclick="scrollToTop()"
      class="btn btn-dark"
      id="myBtn"
      style="border: solid 2px #dc3545"
    >
      <i
        class="fa fa-angle-double-up"
        aria-hidden="true"
        style="font-size: 42px"
      ></i>
    </button>
    <script src="JS/script.js"></script>
    <script src="JS/script_form.js"></script>
    <script src="JS/script_cart.js"></script>
  </body>
</html>
