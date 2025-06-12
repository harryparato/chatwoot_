# Karaoke Web App

Simple PHP web application to manage karaoke nights with queue management, user roles and voting.

## Setup
1. Import `setup.sql` in your MySQL server.
2. Configure database credentials in `config.php`.
3. Deploy the `karaoke-webapp` folder on your Apache server.

## Features
- User authentication with roles: admin, manager, client, judge.
- Add songs with YouTube link or search via YouTube API.
- Drag and drop queue reordering.
- Public voting for performed songs.
- Basic category management pre-filled in SQL file.
