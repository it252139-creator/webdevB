// assets/main.js
function toggleReplies() {
  document.querySelectorAll(".reply-toggle").forEach((btn) => {
    btn.addEventListener("click", () => {
      const target = document.getElementById(btn.dataset.target);
      if (target) target.classList.toggle("hidden");
    });
  });
}

function updateCommentsToggle() {
  const commentsToggle = document.getElementById("comments-toggle");
  const commentsPanel = document.getElementById("comments-panel");
  if (!commentsToggle || !commentsPanel) return;

  commentsToggle.addEventListener("click", () => {
    const isHidden = commentsPanel.classList.toggle("hidden");
    commentsToggle.textContent = isHidden ? "コメントを表示" : "コメントを閉じる";
  });
}

function getPageState() {
  const commentsPanel = document.getElementById("comments-panel");
  if (!commentsPanel) return null;
  return {
    commentsVisible: !commentsPanel.classList.contains("hidden"),
    replyPanels: Array.from(document.querySelectorAll(".replies")).filter((panel) => !panel.classList.contains("hidden")).map((panel) => panel.id),
    scrollTop: window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0,
  };
}

function restorePageState() {
  const savedState = sessionStorage.getItem("commentlyPageState");
  if (!savedState) return;

  try {
    const state = JSON.parse(savedState);
    const commentsToggle = document.getElementById("comments-toggle");
    const commentsPanel = document.getElementById("comments-panel");

    if (state.commentsVisible && commentsPanel) {
      commentsPanel.classList.remove("hidden");
      if (commentsToggle) commentsToggle.textContent = "コメントを閉じる";
    }

    if (Array.isArray(state.replyPanels)) {
      state.replyPanels.forEach((id) => {
        const panel = document.getElementById(id);
        if (panel) panel.classList.remove("hidden");
      });
    }

    if (typeof state.scrollTop === "number") {
      window.scrollTo(0, state.scrollTop);
    }
  } catch (error) {
    console.error("Failed to restore commently page state:", error);
  }

  sessionStorage.removeItem("commentlyPageState");
}

function preservePageStateOnSubmit() {
  document.querySelectorAll("form.comment-form, form.reply-form, form.inline").forEach((form) => {
    form.addEventListener("submit", () => {
      const state = getPageState();
      if (state) {
        sessionStorage.setItem("commentlyPageState", JSON.stringify(state));
      }
    });
  });
}

function buildYouTubeWatchUrl(embedUrl) {
  try {
    const url = new URL(embedUrl, window.location.href);
    const embedPath = url.pathname.split("/");
    if (embedPath[1] === "embed" && embedPath[2]) {
      return `https://www.youtube.com/watch?v=${embedPath[2]}`;
    }
  } catch (error) {
    return null;
  }
  return null;
}

function fetchVideoMeta(videoUrl) {
  const oembedUrl = `https://www.youtube.com/oembed?url=${encodeURIComponent(videoUrl)}&format=json`;
  return fetch(oembedUrl)
    .then((response) => {
      if (!response.ok) throw new Error("oEmbed fetch failed");
      return response.json();
    })
    .catch(() => null);
}

function refreshMovieInfo(src) {
  const titleEl = document.getElementById("movie-title");
  const channelEl = document.getElementById("movie-channel");
  if (!titleEl || !channelEl || !src) return;

  const videoUrl = buildYouTubeWatchUrl(src);
  if (!videoUrl) return;

  fetchVideoMeta(videoUrl).then((meta) => {
    if (!meta) return;
    titleEl.textContent = meta.title;
    channelEl.textContent = meta.author_name;
  });
}

function refreshMovieInfoFromPlayer(player) {
  const titleEl = document.getElementById("movie-title");
  const channelEl = document.getElementById("movie-channel");
  if (!titleEl || !channelEl || !player) return;

  const videoData = player.getVideoData();
  if (!videoData || !videoData.video_id) return;

  if (videoData.title) {
    titleEl.textContent = videoData.title;
  }
  if (videoData.author) {
    channelEl.textContent = videoData.author;
  }

  if (!videoData.author || !videoData.title) {
    const videoUrl = `https://www.youtube.com/watch?v=${videoData.video_id}`;
    fetchVideoMeta(videoUrl).then((meta) => {
      if (!meta) return;
      titleEl.textContent = meta.title;
      channelEl.textContent = meta.author_name;
    });
  }
}

function loadYouTubeAPI() {
  return new Promise((resolve) => {
    if (window.YT && window.YT.Player) {
      resolve(window.YT);
      return;
    }

    const tag = document.createElement("script");
    tag.src = "https://www.youtube.com/iframe_api";
    document.head.appendChild(tag);

    window.onYouTubeIframeAPIReady = function () {
      resolve(window.YT);
    };
  });
}

function initYouTubePlayer() {
  const playerElement = document.getElementById("movie-player");
  if (!playerElement) return;

  loadYouTubeAPI().then((YT) => {
    const player = new YT.Player(playerElement, {
      events: {
        onReady: () => {
          refreshMovieInfoFromPlayer(player);
        },
        onStateChange: (event) => {
          if (event.data === YT.PlayerState.PLAYING) {
            refreshMovieInfoFromPlayer(player);
          }
        },
      },
    });

    // If the iframe src is updated manually outside the API, still refresh title.
    const observer = new MutationObserver(() => {
      const currentSrc = playerElement.getAttribute("src");
      if (currentSrc) {
        refreshMovieInfo(currentSrc);
      }
    });
    observer.observe(playerElement, { attributes: true, attributeFilter: ["src"] });
  });
}

toggleReplies();
updateCommentsToggle();
preservePageStateOnSubmit();
restorePageState();
initYouTubePlayer();
