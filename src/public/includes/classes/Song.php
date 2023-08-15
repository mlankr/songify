<?php

    class Song {
        private $pdo;
        private $id;
        private $songData;
        private $title;
        private $artistId;
        private $albumId;
        private $genreId;
        private $duration;
        private $path;
        private $albumOrder;

        public function __construct($pdo, $id) {
            $this->pdo = $pdo;
            $this->id = $id;

            $songTitleQuery = "SELECT * FROM songs WHERE id='$this->id'";
            $songTitlePrepareQuery = $this->pdo->prepare($songTitleQuery);
            $songTitlePrepareQuery->execute();
            $this->songData = $songTitlePrepareQuery->fetch(PDO::FETCH_ASSOC);

            $this->title = $this->songData['title'];
            $this->artistId = $this->songData['artist'];
            $this->albumId = $this->songData['album'];
            $this->genreId = $this->songData['genre'];
            $this->duration = $this->songData['duration'];
            $this->path = $this->songData['path'];
            $this->albumOrder = $this->songData['albumOrder'];
        }

        public function getSongData() {
            return $this->songData;
        }

        public function getId() {
            return $this->id;
        }

        public function getTitle() {
            return $this->title;
        }

        public function getArtistId() {
            return $this->artistId;
        }

        public function getAlbumId() {
            return $this->albumId;
        }

        public function getGenreId() {
            return $this->genreId;
        }

        public function getDuration() {
            return $this->duration;
        }

        public function getPath() {
            return $this->path;
        }

        public function getAlbumOrder() {
            return $this->albumOrder;
        }

        public function getArtist() {
            return new Artist($this->pdo, $this->artistId);
        }

        public function getAlbum() {
            return new Album($this->pdo, $this->albumId);
        }

        public function updatePlays() {
            $songPlaysUpdate = "Update songs SET plays=plays+1 WHERE id='$this->id'";
            $songPlaysUpdatePrepareQuery = $this->pdo->prepare($songPlaysUpdate);
            return $songPlaysUpdatePrepareQuery->execute();
        }
    }
