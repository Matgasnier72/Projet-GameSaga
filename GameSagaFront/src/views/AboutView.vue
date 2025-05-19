<template>
  <div class="about">
    <h2>À propos de GameSaga</h2>

    <div class="about-section">
      <div class="history-section">
        <h3>Notre Histoire</h3>
        <p>
          L'aventure de GameSaga commença en 1242, après que des moines copistes eurent découvert le bilboquet.
          Quelques jours après avoir joué, ils décidèrent d'écrire un essai nommé "Bilboquetus Nullum" où ils
          décrivirent leur expérience négative durant leur partie.
        </p>
      </div>

      <div class="mission-section">
        <h3>Notre Mission</h3>
        <p>
          GameSaga a pour mission de créer un espace où les passionnés de jeux vidéo peuvent partager leurs
          expériences, découvrir de nouveaux jeux et échanger avec d'autres joueurs.
        </p>
      </div>

      <div class="disclaimer-section">
        <h3>Note importante</h3>
        <p>
          Ce site est un projet d'apprentissage développé dans le cadre d'une formation.
          Il utilise des technologies modernes comme Vue.js et Laravel pour offrir une expérience
          utilisateur optimale.
        </p>
      </div>

      <div class="team-section">
        <h3>L'Équipe</h3>
        <div class="team-members">
          <div class="team-member">
            <img src="../assets/chibi.png" alt="avatar du dev">
            <p>Mat</p>
            <p class="member-role">Développeur Full-Stack</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.about {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

h2 {
  text-align: center;
  color: #dc3545;
  font-family: "Press Start 2P", system-ui;
  margin-bottom: 3rem;
  font-size: 2rem;
  margin-top: 5rem;
}

h3 {
  color: #dc3545;
  margin-bottom: 1.5rem;
  font-size: 1.5rem;
}

.about-section {
  display: flex;
  flex-direction: column;
  gap: 3rem;
}

.history-section,
.mission-section,
.disclaimer-section,
.team-section {
  background-color: rgba(255, 255, 255, 0.05);
  padding: 2rem;
  border-radius: 8px;
  transition: transform 0.3s ease;
}

.history-section:hover,
.mission-section:hover,
.disclaimer-section:hover,
.team-section:hover {
  transform: translateY(-5px);
}

p {
  color: #fff;
  line-height: 1.8;
  margin-bottom: 1rem;
}

.team-members {
  display: flex;
  justify-content: center;
  gap: 2rem;
  margin-top: 2rem;
}

.team-member {
  text-align: center;
}
.team-member img {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  margin-bottom: 1rem;
  transition: all 0.3s ease;
  object-fit: cover;
  box-shadow: 0 4px 8px rgba(220, 53, 69, 0.2);
}

.team-member img:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 12px rgba(220, 53, 69, 0.3);
}

.team-member p {
  margin: 0.5rem 0;
  font-size: 1.2rem;
  font-weight: bold;
}

.member-icon {
  width: 64px;
  height: 64px;
  fill: #dc3545;
  margin-bottom: 1rem;
}

.member-role {
  font-size: 1.1rem;
  color: #dc3545;
}

@media (max-width: 768px) {
  .about {
    padding: 1rem;
  }
    .team-member img {
    width: 120px;
    height: 120px;
  }

  .team-member p {
    font-size: 1rem;
  }

  h2 {
    font-size: 1.5rem;
    margin-bottom: 2rem;
  }

  h3 {
    font-size: 1.2rem;
  }

  .about-section {
    gap: 2rem;
  }

  .history-section,
  .mission-section,
  .disclaimer-section,
  .team-section {
    padding: 1.5rem;
  }
}
@media (max-width: 480px) {
  .team-member img {
    width: 100px;
    height: 100px;
    border-width: 2px;
  }
}
</style>