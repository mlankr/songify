<?php

    class Album {
        private $pdo;
        private $id;
        private $albumData;
        private $title;
        private $artistId;
        private $genre;
        private $artworkPath;

        public function __construct($pdo, $id) {
            $this->pdo = $pdo;
            $this->id = $id;

            $albumTitleQuery = "SELECT * FROM albums WHERE id='$this->id';";
            $albumTitlePrepareQuery = $this->pdo->prepare($albumTitleQuery);
            $albumTitlePrepareQuery->execute();
            $this->albumData = $albumTitlePrepareQuery->fetch(PDO::FETCH_ASSOC);

            $this->title = $this->albumData['title'];
            $this->artistId = $this->albumData['artist'];
            $this->genre = $this->albumData['genre'];
            $this->artworkPath = $this->albumData['artworkPath'];
        }

        public function getId() {
            return $this->id;
        }

        public function getAlbumData() {
            return $this->albumData;
        }

        public function getTitle() {
            return $this->title;
        }

        public function getArtistId() {
            return $this->artistId;
        }

        public function getArtist() {
            return new Artist($this->pdo, $this->artistId);
        }

        public function getGenre() {
            return $this->genre;
        }

        public function getArtworkPath() {
            return $this->artworkPath;
        }

        public function getNumberOfSongs() {
            $totalSongsQuery = "SELECT COUNT(id) FROM songs WHERE album='$this->id';";
            $totalSongsPrepareQuery = $this->pdo->prepare($totalSongsQuery);
            $totalSongsPrepareQuery->execute();
            return $totalSongsPrepareQuery->fetchColumn();
        }

        public function getSongIds() {
            $songIdsQuery = "SELECT id FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC;";
            $songIdsQueryPrepareQuery = $this->pdo->prepare($songIdsQuery);
            $songIdsQueryPrepareQuery->execute();
            return $songIdsQueryPrepareQuery->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }