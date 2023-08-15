<?php

    class Playlist {
        private $pdo;
        private $id;
        private $name;
        private $owner;

        public function __construct($pdo, $data) {

            $this->pdo = $pdo;

            if (!is_array($data)) {
                // data is an id (string)
                $playlistTitleQuery = "SELECT * FROM playlists WHERE id='$data';";
                $playlistTitlePrepareQuery = $this->pdo->prepare($playlistTitleQuery);
                $playlistTitlePrepareQuery->execute();
                $data = $playlistTitlePrepareQuery->fetch(PDO::FETCH_ASSOC);
            }
            $this->id = $data['id'];
            $this->name = $data['name'];
            $this->owner = $data['owner'];
        }

        public function getId() {
            return $this->id;
        }

        public function getName() {
            return $this->name;
        }

        public function getOwner() {
            return $this->owner;
        }

        public function getNumberOfSongs() {
            $totalSongsQuery = "SELECT COUNT(songId) FROM playlistSongs WHERE playlistId='$this->id';";
            $totalSongsPrepareQuery = $this->pdo->prepare($totalSongsQuery);
            $totalSongsPrepareQuery->execute();
            return $totalSongsPrepareQuery->fetchColumn();
        }

        public function getSongIds() {
            $songIdsQuery = "SELECT songId FROM playlistSongs WHERE playlistId='$this->id' ORDER BY playlistOrder ASC;";
            $songIdsQueryPrepareQuery = $this->pdo->prepare($songIdsQuery);
            $songIdsQueryPrepareQuery->execute();
            return $songIdsQueryPrepareQuery->fetchAll(PDO::FETCH_COLUMN, 0);
        }

        public static function getPlaylistDropdown($pdo, $username) {
            $dropdown = '<label for="selectPlaylist"></label><select name="selectPlaylist" id="selectPlaylist" class="item playlist">
                            <option value="" selected>Add to playlist</option>';

            $playlistQuery = "SELECT id, name FROM playlists WHERE owner='$username'";
            $playlistPrepareQuery = $pdo->prepare($playlistQuery);
            $playlistPrepareQuery->execute();
            $allPlaylists = $playlistPrepareQuery->fetchAll();

            foreach ($allPlaylists as $playlist) {
                $id = $playlist['id'];
                $name = $playlist['name'];
                $dropdown = $dropdown . "<option value='$id'>$name</option>";
            }

            return $dropdown . ' </select > ';
        }
    }