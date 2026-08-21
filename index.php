
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// 1. استدعاء ملف الاتصال (تأكد من أن db_config.php في نفس المجلد)
require_once 'db_config.php';

$success = "";
$error = "";

// 2. معالجة الإرسال
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_reservation'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $filiere = htmlspecialchars($_POST['filiere']);
    $message = htmlspecialchars($_POST['message']);

    if (!empty($nom) && !empty($email) && !empty($telephone)) {
        try {
            $sql = "INSERT INTO reservations (full_name, email, phone, filiere, message) 
                    VALUES (:full_name, :email, :phone, :filiere, :message)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'full_name' => $nom,
                'email'     => $email,
                'phone'     => $telephone,
                'filiere'   => $filiere,
                'message'   => $message
            ]);
            $success = "Votre demande a été enregistrée avec succès ! Un conseiller vous contactera bientôt.";
        } catch (PDOException $e) {
            $error = "Erreur lors de l'enregistrement : veuillez réessayer.";
        }
    } else {
        $error = "Veuillez remplir les champs obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MID.MA — Modern Innovation Digital | Formations RAD, Low-Code, IoT & Robotics à Rabat</title>
<meta name="description" content="MID.MA forme la nouvelle génération d'ingénieurs marocains aux technologies qui comptent : Développement Rapide (RAD), Low-Code/No-Code, IoT et Robotics. Une pédagogie 100% pratique, ancrée sur le terrain, à Rabat.">
<meta name="keywords" content="MID.MA, formation IoT Maroc, Low-Code No-Code Rabat, Robotics Arduino Micro:bit, RAD développement rapide, formation technologique Rabat, ESP32 Raspberry Pi formation">
<meta name="author" content="MID.MA — Modern Innovation Digital">
<link rel="canonical" href="https://www.mid.ma/">

<!-- Open Graph (Facebook / LinkedIn) -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="MID.MA">
<meta property="og:title" content="MID.MA — Modern Innovation Digital | L'apprentissage par la pratique">
<meta property="og:description" content="Découvrez les formations RAD, Low-Code/No-Code, IoT et Robotics de MID.MA : une approche 100% pratique pour maîtriser les technologies de demain, à Rabat.">
<meta property="og:url" content="https://www.mid.ma/">
<meta property="og:image" content="https://www.mid.ma/assets/og-cover.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="fr_MA">

<!-- Polices -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<!-- Tailwind CSS (CDN) -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          'midnight': '#0B3984',
          'midnight-deep': '#071F4D',
          'midnight-card': '#123B85',
          'neon': '#00F076',
          'ink': '#0A1730'
        },
        fontFamily: {
          display: ['"Space Grotesk"', 'sans-serif'],
          body: ['"Inter"', 'sans-serif'],
          mono: ['"JetBrains Mono"', 'monospace']
        }
      }
    }
  }
</script>

<style>
  html { scroll-behavior: smooth; }
  body { background-color: #0B3984; }
  .circuit-line { stroke-dasharray: 8 6; stroke-dashoffset: 0; animation: signal-travel 3.2s linear infinite; }
  @keyframes signal-travel { to { stroke-dashoffset: -140; } }
  .formation-card { transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease; }
  .formation-card:hover { transform: translateY(-6px); border-color: #00F076; box-shadow: 0 0 0 1px rgba(0,240,118,0.25), 0 20px 40px -20px rgba(0,240,118,0.35); }
  .cta-neon { background-color: #00F076; color: #0A1730; transition: transform 0.2s ease, box-shadow 0.2s ease; }
  .cta-neon:hover { transform: translateY(-2px); box-shadow: 0 10px 24px -8px rgba(0,240,118,0.55); }
</style>
</head>

<body class="font-body text-white">

<!-- NAVBAR -->
<header class="fixed top-0 inset-x-0 z-50 bg-midnight-deep/90 backdrop-blur border-b border-white/10">
  <nav class="max-w-7xl mx-auto px-5 sm:px-8 h-16 flex items-center justify-between">
    <a href="index.html" class="flex items-center">
      <img src="https://raw.githubusercontent.com/bouaatar/mid/refs/heads/main/small.jpg" alt="Logo MID.MA" class="h-10 w-auto rounded">
    </a>
    <div class="hidden lg:flex items-center gap-8 font-medium text-sm">
      <a href="index.html" class="hover:text-neon transition-colors">Accueil</a>
      <a href="contact.html" class="hover:text-neon transition-colors">Contactez-nous</a>
    </div>
    <a href="#formulaire" class="hidden lg:inline-flex cta-neon font-semibold text-sm px-5 py-2.5 rounded-full">Réserver ma place</a>
    <button id="menu-toggle" class="lg:hidden p-2"><svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h16" stroke="white" stroke-width="2" stroke-linecap="round"/></svg></button>
  </nav>
</header>

<!-- HERO -->
<section class="relative min-h-screen flex items-center pt-16 overflow-hidden">
  <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline><source src="https://raw.githubusercontent.com/bouaatar/mid/refs/heads/main/vid1.mp4" type="video/mp4"></video>
  <div class="absolute inset-0 bg-midnight/60"></div>
  <div class="relative max-w-5xl mx-auto px-5 sm:px-8 text-center">
    <h1 class="font-display font-700 text-4xl sm:text-6xl mb-6">Modern Innovation Digital</h1>
    <p class="text-white/85 text-lg sm:text-xl max-w-2xl mx-auto mb-10">L'apprentissage par la pratique, à Rabat.</p>
    <a href="#formulaire" class="cta-neon font-semibold px-8 py-3.5 rounded-full">Réserver ma place</a>
  </div>
</section>

<!-- FORMULAIRE -->
<section id="formulaire" class="relative py-24 bg-midnight">
  <div class="max-w-3xl mx-auto px-5">
    <div class="text-center mb-12">
      <h2 class="font-display font-700 text-3xl sm:text-4xl">Réservez votre place</h2>
    </div>

    <div class="bg-midnight-deep/60 border border-white/10 rounded-3xl p-6 sm:p-10">
      <?php if($success): ?><div class="mb-6 p-4 bg-neon/20 border border-neon text-neon rounded-xl text-center"><?php echo $success; ?></div><?php endif; ?>
      <?php if($error): ?><div class="mb-6 p-4 bg-red-500/20 border border-red-500 text-red-300 rounded-xl text-center"><?php echo $error; ?></div><?php endif; ?>

      <form method="POST" action="#formulaire" class="grid sm:grid-cols-2 gap-5">
        <input type="text" name="nom" required placeholder="Votre nom" class="w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3 text-sm focus:border-neon">
        <input type="email" name="email" required placeholder="Votre e-mail" class="w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3 text-sm focus:border-neon">
        <input type="tel" name="telephone" required placeholder="Téléphone" class="w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3 text-sm focus:border-neon">
        <select name="filiere" class="w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3 text-sm focus:border-neon text-black">
            <option>RAD</option>
            <option>Low-Code / No-Code</option>
            <option>IoT</option>
            <option>Robotics</option>
        </select>
        <textarea name="message" rows="3" placeholder="Message" class="sm:col-span-2 w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3 text-sm focus:border-neon"></textarea>
        <button type="submit" name="submit_reservation" class="sm:col-span-2 cta-neon font-semibold py-3.5 rounded-full">Envoyer ma demande</button>
      </form>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-midnight-deep border-t border-white/10 pt-16 pb-8 text-center text-white/40 text-xs">
  © 2026 MID.MA — Modern Innovation Digital.
</footer>

<script>
  document.getElementById('menu-toggle').addEventListener('click', () => {
    document.getElementById('mobile-menu')?.classList.toggle('hidden');
  });
</script>
</body>
</html>
