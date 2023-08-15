<?php

    class Artist {
        private $pdo;
        private $id;
        private $artistData;
        private $artistName;

        public function __construct($pdo, $id) {
            $this->pdo = $pdo;
            $this->id = $id;

            $artistQuery = "SELECT * FROM artists WHERE id='$this->id'";
            $artistPrepareQuery = $this->pdo->prepare($artistQuery);
            $artistPrepareQuery->execute();
            $this->artistData = $artistPrepareQuery->fetch(PDO::FETCH_ASSOC);

            $this->artistName = $this->artistData['name'];
        }

        public function getId() {
            return $this->id;
        }

        public function getArtistData() {
            return $this->artistData;
        }

        public function getArtistName() {
            return $this->artistName;
        }

        public function getSongIds() {
            $songIdsQuery = "SELECT id FROM songs WHERE artist='$this->id' ORDER BY plays DESC;";
            $songIdsQueryPrepareQuery = $this->pdo->prepare($songIdsQuery);
            $songIdsQueryPrepareQuery->execute();
            return $songIdsQueryPrepareQuery->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }