<?php
/**
*
* install [Greek]
*
* @package language
* @version $Id: install.php,v 1.119 2007/07/24 15:17:47 acydburn Exp $
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

/**
* Language keys for phpBB Garage auto installer
*/
$lang = array_merge($lang, array(
	'FILES_REQUIRED_EXPLAIN'	=> '<strong>Απαιτείται</strong> - Για να λειτουργήσει σωστά, το phpBB Garage χρειάζεται να έχει πρόσβαση σε κάποια αρχεία ή φακέλους. Αν δείτε "Δεν βρέθηκε" θα χρειαστεί να δημιουργήσετε το σχετικό αρχείο ή φάκελο. Αν δείτε "Μη-εγγράψιμο" θα χρειαστεί να αλλάξετε τα δικαιώματα του αρχείου ή φακέλου ώστε να επιτρέψετε στο phpBB Garage να γράψει σε αυτό.',

	'INSTALL_CONGRATS_EXPLAIN'	=> '
		<p>Εγκαταστήσατε με επιτυχία το phpBB Garage %1$s. Από εδώ, έχετε δύο επιλογές για το τι να κάνετε με το νέο σας Γκαράζ:</p>
		<h2>Μετατρέψτε ένα σύστημα Γκαράζ σε phpBB Garage</h2>
		<p>Το πρόγραμμα εγκατάστασης του phpBB Garage υποστηρίζει τη μετατροπή από το phpBB Garage 1.x.x και άλλα συστήματα Γκαράζ σε phpBB Garage 2. Αν έχετε ένα υπάρχον Γκαράζ που θέλετε να μετατρέψετε,  παρακαλώ <a href="%2$s">συνεχίστε στο μετατροπέα</a>.</p>
		<h2>Βγείτε στον "αέρα" με το phpBB Garage 2!</h2>
		<p>Πατώντας το παρακάτω κουμπί θα μεταβείτε στον Πίνακα Ελέγχου Διαχειριστή (ACP). αφιερώστε λίγο χρόνο για να εξετάσετε τις προσφερόμενες επιλογές. Θυμηθείτε πως η βοήθεια είναι διαθέσιμη μέσω του <a href="http://www.phpbbgarage.com/support/documentation/3.0/">Documentation</a> και της <a href="http://www.phpbbgarage.com/community/viewforum.php?f=4">κοινότητας υποστήριξης εκδόσεων beta</a>, δείτε το  <a href="%3$s">README</a> για περισσότερες πληροφορίες.</p>',
	'UPDATE_CONGRATS_EXPLAIN'	=> '
		<p>Κάνατε επιτυχώς αναβάθμιση σε phpBB Garage %1$s.',
	'INSTALL_INTRO_BODY'		=> 'Με αυτή την επιλογή μπορείτε να εγκαταστήσετε το phpBB Garage.</p>

	<p><strong>Σημείωση:</strong> Ο οδηγός εγκατάστασης θα σας βοηθήσει με τα βήματα που είναι σχετικά με τη βάση δεδομένων &amp; επίσης την επεξεργασία των αρχείων της phpBB. Παρακαλώ σιγουρευτείτε πως διαβάσατε τα αρχεία MODX για τα template &amp; τις γλώσσες για να ολοκληρώσετε την εγκατάσταση.</p>

	<p>To phpBB Garage υποστηρίζει τις ακόλουθες βάσεις δεδομένων:</p>
	<ul>
		<li>MySQL 3.23 ή μεγαλύτερη (MySQLi supported)</li>
		<li>PostgreSQL 7.3+</li>
		<li>SQLite 2.8.2+</li>
		<li>Firebird 2.0+</li>
		<li>MS SQL Server 2000 ή πιο πρόσφατο (απευθείας ή μέσω  ODBC)</li>
		<li>Oracle</li>
	</ul>',
	'PHP_REQUIRED_MODULE'		=> 'Απαιτούμενα modules',
	'PHP_REQUIRED_MODULE_EXPLAIN'	=> '<strong>Απαιτείται</strong> - αυτά τα modules ή εφαρμογές απαιτούνται.',

	'OVERVIEW_BODY'			=> 'Καλώς ορίσατε στην δοκιμαστική έκδοση της επόμενης γενιάς του phpBB Garage μετά την 1.x.x, phpBB Garage 2.0! Αυτή η έκδοση σκοπεύει να μας βοηθήσει να ανακαλύψουμε πιθανά bugs και άλλα προβλήματα.</p><p>Παρακαλώ διαβάστε <a href="../docs/INSTALL.html">τον οδηγό εγκατάστασης</a> για περισσότερες πληροφορίες σχετικά με την εγκατάσταση του phpBB Garage</p><p><strong style="text-transform: uppercase;">Σημ:</strong> Αυτή η έκδοση <strong style="text-transform: uppercase;">δεν ειναι ακομη τελικη</strong>. Ίσως να θέλετε να περιμένετε την τελική έκδοση πριν την τρέξετε σε κανονικό περιβάλλον.</p><p>Ο οδηγός εγκατάστασης θα σας καθοδηγήσει στην διαδικασία εγκατάστασης του phpBB Garage, στην μετατροπή από διαφορετικό σύστημα Γκαράζ ή στην αναβάθμιση στην τελευταία έκδοση του phpBB Garage. Για περισσσότερες πληροφοσίες σχετικά με την κάθε επιλογή, παρακαλώ επιλέξτε από το παραπάνω μενού.',
	'REQUIREMENTS_EXPLAIN'		=> 'Πριν συνεχίσετε με την πλήρη εγκατάσταση, το phpBB Garage θα κάνει κάποιες δοκιμές στις ρυθμίσεις του διακομιστή και των αρχείων σας για να σιγουρευτεί ότι μπορείτε να εγκαταστήσετε και να τρέξετε το phpBB Garage. Παρακαλώ σιγουρευτείτε πως διαβάζετε προσεκτικά τα αποτελέσματα και μην συνεχίζετε εκτός και αν όλες οι δοκιμές τελειώνουν επιτυχημένα. Αν επιθυμείτε να χρησιμοποιήσετε οποιαδήποτε χαρακτηριστικά εξαρτώνται από προαιρετικές δοκιμές, πρέπει να σιγουρευτείτε πως και αυτές οι δοκιμές ολοκληρώνονται με επιτυχία.',
	'SOFTWARE'			=> 'Λογισμικό Γκαράζ',
	'STAGE_OPTIONAL'		=> 'Προαιρετικές ρυθμίσεις',
	'STAGE_OPTIONAL_EXPLAIN'	=> 'Οι επιλογές σε αυτή τη σελίδα σας επιτρέπουν να προσθέσετε κάποια εξ\' ορισμού δεδομένα κατά την εγκατάσταση. Αυτές οι επιλογές δεν είναι απαραίτητες για την εγκατάσταση, όμως αν δεν τις χρησιμοποιήσετε θα χρειαστεί να εισάγετε μόνοι σας αντικείμενα όπως μάρκες, μοντέλα &amp; κατηγορίες μετά την εγκατάσταση.',
	'STAGE_CREATE_TABLE_EXPLAIN'	=> 'Οι πίνακες που χρειάζονται από το phpBB Garage δημιουργήθηκαν και απέκτησαν τα απαραίτητα δεδομένα και κάποια προαιρετικά αν το επιλέξατε. Συνεχίστε στην επόμενη οθόνη για να εγκαταστήσετε νέους τύπους προσβάσεων που είναι απαραίτητες για το phpBB Garage.',
	'STAGE_CREATE_PERMISSIONS'	=> 'Δημιουργία προσβάσεων',
	'STAGE_CREATE_PERMISSIONS_EXPLAIN'	=> 'Νέες προσβάσεις που απαιτούνται από το phpBB Garage δημιουργήθηκαν και εφαρμόστηκαν στους εξ\' ορισμού ρόλους αν αυτοί υπάρχουν. Μετά την εγκατάσταση πρέπει να επιβεβαιώσετε πως είσαστε ικανοποιημένοι με τις νέες προσβάσεις.',
	'STAGE_INSTALL_MODULES'		=> 'Εγκατάσταση modules',
	'STAGE_INSTALL_MODULES_EXPLAIN'	=> 'Τα modules του phpBB Garage εγκαταστάθηκαν.',

	'STAGE_DATA'			=> 'Δεδομένα',
	'STAGE_DATA_EXPLAIN'		=> 'Όλα τα δεδομένα του phpBB Garage μετακινήθηκαν. Η συνέχεια θα σβήσει όλα τα αρχεία.',
	'STAGE_FILES'			=> 'Αρχεία',
	'STAGE_FILES_EXPLAIN'		=> 'Όλα τα αρχεία του phpBB Garage μετακινήθηκαν.',

	'SUPPORT_BODY'			=> 'Κατά τη διάρκεια της φάσης beta θα παρέχεται μικρή βοήθεια στην <a href="http://forums.phpbbgarage.com/">κοινότητα υποστήριξης του phpBB Garage </a>. Θα παρέχονται απαντήσεις σε γενικές ερωτήσεις εγκατάστασης, προβλήματα παραμετροποίησης, προβλήματα μετατροπής καθώς και υποστήριξη για επίλυση κοινών προβλημάτων που οφείλονται κυρίως σε bugs.',

	'WELCOME_INSTALL'		=> 'Καλώς ορίσατε στην εγκατάσταση του phpBB Garage',
	'INSERT_OPTIONS'		=> 'Προαιρετικά δεδομένα',
	'INSERT_MAKES'			=> 'Εισαγωγή Μαρκών',
	'INSERT_MAKES_EXPLAIN'		=> 'Εισάγει κάποιες προεπιλεγμένες μάρκες καθώς και μοντέλα για αυτές.',
	'INSERT_CATEGORIES'		=> 'Εισαγωγή κατηγοριών',
	'INSERT_CATEGORIES_EXPLAIN'	=> 'Εισάγει κάποιες προεπιλεγμένες κατηγορίες μετατροπών.',
	'CURRENT_VERSION'				=> 'Τρέχουσα έκδοση',
	'LATEST_VERSION'		=> 'Τελευταία έκδοση',
));

/**
* Language keys for phpBB Garage converter
*/
$lang = array_merge($lang, array(
	'CONFIG_PHPBB_EMPTY'		=> 'Η μεταβλητή ρύθμισης του phpBB Garage για "%s" είναι άδεια.',
	'CONVERT_COMPLETE_EXPLAIN'	=> 'Μετατρέψατε επιτυχημένατο Γκαράζ σας στο phpBB Garage 2.0. Μπορείτε τώρα να συνδεθείτε και να <a href="../../garage.php">δείτε το Γκαράζ</a>. Παρακαλώ σιγουρευτείτε πως οι ρυθμίσεις μεταφέρθηκαν σωστά πριν ενεργοποιήσετε το φόρουμ διαγράφοντας το φάκελο εγκατάστασης. Θυμηθείτε πως η βοήθεια χρήσης του phpBB Garage είναι διαθέσιμο  στο online <a href="http://www.phpbbgarage.com/support/documentation/2.0/">Documentation</a> και στην <a href="http://www.phpbbgarage.com/community/viewforum.php?f=4">κοινότητα υποστήριξης εκδόσεων beta</a>.',
	'CONVERT_INTRO'			=> 'Καλως ήρθατε στο πρόγραμμα μετατροπής του phpBB Garage',
	'CONVERT_INTRO_BODY'		=> 'Από εδώ , μπορείτε να εισάγετε από άλλα (εγκατεστημένα) συστήματα Γκαράζ. Η παρακάτω λίστα δείχνει όλα τα διαθέσιμα προγράμματα μετατροπής. Αν δεν φαίνεται κανένα πρόγραμμα μετατροπής για την έκδοση Γκαράζ από την οποία θέλετε να κάνετε την μετατροπή, παρακαλώ ελέγξτε τον ιστότοπό μας όπου μπορεί να υπάρχουν αρχεία μετατροπής διαθέσιμα προς κατέβασμα.',
	
	'PRE_CONVERT_COMPLETE'		=> 'Όλα τα προ-εγκατάστασης βήματα ολοκληρώθηκαν. Μπορείτε τώρα να ξεκινήσετε την πραγματική διαδικασία μετατροπής. Παρακαλώ σημειώστε πως μπορεί να χρειαστεί να κάνετε πολλές χειροκίνητες ρυθμίσεις. Μετά την μετατροπή προσέξτε ειδικά τα δικαιώματα, ξαναδημιουργήστε την Αναζήτηση Ευρετηρίου αν είναι απαραίτητο και επίσης σιγουρευτείτε πως τα αρχεία αντιγράφηκαν σωστά, για παράδειγμα τα άβαταρ και τα εικονίδια.',
));

/**
* Language keys for phpBB Garage auto updater & converter
*/
$lang = array_merge($lang, array(
	'ALL_FILES_UP_TO_DATE'		=> 'Όλα τα αρχεία είναι ενημερωμένα και ανήκουν στην τελευταία έκδοση του phpBB Garage. Θα πρέπει να επιβεβαιώσετε τώρα ότι όλα δουλεύουν όπως πρέπει.',

	'CHECK_FILES_UP_TO_DATE'	=> 'Σύμφωνα με τη βάση δεδομένων σας η έκδοσή σας είναι ενημερωμένη. Ίσως να θέλετε να συνεχίσετε με τον έλεγχο αρχείων για να σιγουρευτείτε πως όλα σας τα αρχεία είναι ενημερωμένα με την τελευταία έκδοση του phpBB Garage.',


	'NO_UPDATE_FILES_OUTDATED'	=> 'Δεν βρέθηκε έγκυρος φάκελος ενημέρωσης, παρακαλώ σιγουρευτείτε ότι ανεβάσατε τα σχετικά αρχεία.<br /><br />Η εγκατάστασή σας <strong>δεν </strong> φαίνεται ενημερωμένη. Οι ενημερώσεις είναι διαθέσιμες για την έκδοσή σας του phpBB Garage %1$s, παρακαλώ επισκεφτείτε το <a href="http://www.phpbbgarage.com/downloads/" rel="external">http://www.phpbbgarage.com/downloads/</a> για να αποκτήσετε το σωστό πακέτο για την αναβάθμιση από την έκδοση %2$s στην έκδοση %3$s.',

	'UPDATE_INSTALLATION'		=> 'Ενημέρωση εγκατάστασης phpBB Garage',
	'UPDATE_INSTALLATION_EXPLAIN'	=> 'Με αυτή την επιλογή, μπορείτε να ενημερώσετε την εγκατάσταση του phpBB Garage σας στην τελευταία έκδοση.<br />Κατά τη διάρκεια της διαδικασίας θα ελεγχθούν και τα αρχεία σας. Θα μπορείτε να δείτε προεπισκόπηση όλων των διαφορών των αρχείων πριν την ενημέρωση.<br /><br />Η ενημέρωση αρχείων μπορεί να γίνει με δύο διαφορετικούς τρόπους.</p><h2>Χειροκίνητη ενημέρωση</h2><p>Με αυτή την ενημέρωση μπορείτε να μεταφορτώσετε τα αρχεία σας  ώστε να σιγουρευτείτε πως δεν θα χάσετε ότι αλλαγές έχετε κάνει. Αφού κατεβάσετε αυτό το πακέτο, πρεπει να ανεβάσετε χειροκίνητα τα αρχεία στο ριζικό φάκελο του phpBB garage. Μόλις τελειώσετε μπορείτε να ξαναελέγξετε τα αρχεία ώστε να σιγουρευτείτε πως τα τοποθετήσατε στο σωστό φάκελο.</p><h2>Αυτόματη ενημέρωση με χρήση FTP</h2><p>Αυτή η μέθοδος είναι παρόμοια με την πρώτη, εκτός από το γεγονός ότι δεν χρειάζεται να κατεβάσετε τα αλλαγμένα αρχεία και να τα ξαναανεβάσετε μόνοι σας. Αυτό θα γίνει αυτόματα. Για να μπορέσετε να χρησιμοποιήσετε αυτή την μέθοδο, πρέπει να γνωρίζετε τα στοιχεία του FTP λογαριασμού, αφού θα ερωτηθείτε για αυτά. Μόλις τελειώσετε θα ανακατευθυνθείτε πάλι στον έλεγψο αρχείων πάλι, για να σιγουρευτείτε ότι όλα ενημερώθηκαν επιτυχώς.<br /><br />',
	'UPDATE_INSTRUCTIONS'			=> '

		<h1>Ανακοίνωση έκδοσης</h1>

		<p>Παρακαλώ διαβάστε <a href="%1$s" title="%1$s"><strong>την ανακοίνωση για την τελευταία έκδοση</strong></a> πριν συνεχίσετε την διαδικασία αναβάθμισης, μπορεί να περιέχει χρήσιμες πληροφορίες. Επίσης περιέχει συνδέσμους για κατέβασμα, όπως επίσης λαι το αρχείο καταγραφής αλλαγών.</p>

		<br />

		<h1>Πως να αναβαθμίσετε την εγκατάστασή σας με τη χρήση του Automatic Update Package</h1>

		<p>Ο προτεινόμενος τρόπος αναβάθμισης της εγκατάστασης είναι έγκυρος μόνο για το αυτόματο πακέτο ενημέρωσης. Μπορείτε επίσης να ενημερώσετε την εγκατάσταση χρησιμοποιώντας τις μεθόδους που αναφέρονται στο αρχείο INSTALL.html. Τα βήματα για την αυτόματη αναβάθμιση του phpBB Garage είναι:</p>

		<ul style="margin-left: 20px; font-size: 1.1em;">
			<li>Πηγαίνετε στη <a href="http://www.phpbbgarage.com/downloads/" title="http://www.phpbbgarage.com/downloads/">σελίδα μεταφορτώσεων του phpBB Garage</a> και κατεβάστε το αρχείο "Automatic Update Package".<br /><br /></li>
			<li>Αποσυμπίεση του αρχείου.<br /><br /></li>
			<li>ανεβάστε ολόκληρο τον αποσυμπιεσμένο φάκελο εγκατάστασης στο φάκελο ρίζας του phpBB Garage (εκεί που είναι το αρχείο config.php).<br /><br /></li>
		</ul>

		<p>Μόλις το ανεβάσετε, το φόρουμ σας θα είναι μη ενεργό για τα απλά μέλη λόγω της παρουσίας του φακέλου εγκατάστασης.<br /><br />
		<strong><a href="%2$s" title="%2$s">Ξεκινήστε τώρα την διαδικασία αναβάθμισης στοχεύοντας τον περιηγητή ίντερνετ στο φάκελο εγκατάστασης</a>.</strong><br />
		<br />
		Θα καθοδηγηθείτε κατά την διαδικασία εγκατάστασης. Θα εισοποιηθείτε μόλις ολοκληρωθεί η ενημέρωση.
		</p>
	',
	'UPDATE_INSTRUCTIONS_INCOMPLETE'	=> '

		<h1>Ανιχνεύτηκε ημιτελής ενημέρωση</h1>

		<p>Το phpBB Garage ανίχνευσε μια ημιτελή αυτόματη ενημέρωση. Παρακαλώ σιγουρευτείτε πως ακολουθήσατε όλα τα βήματα του εργαλείου αυτόματης ενημέρωσης. Παρακάτω θα βρείτε ξανά τον σύνδεσμο, ή πηγαίνετε απευθείας στο φάκελο εγκατάστασης.</p>
		',
	'VERSION_CHECK_EXPLAIN'		=> 'Ελέγχει αν η έκδοση του phpBB Garage που χρησιμοποιείτε είναι ενημερωμένη.',
	'VERSION_NOT_UP_TO_DATE'	=> 'Η έκδοση του phpBB Garage σας δεν είναι ενημερωμένη. Παρακαλώ συνεχίστε με διαδικασία ενημέρωσης.',
	'VERSION_NOT_UP_TO_DATE_ACP'=> 'Η έκδοση του phpBB Garage σας δεν είναι ενημερωμένη.<br />Παρακάτω θα βρείτε ένα σύνδεσμο προς την ανακοίνωση της νέας έκδοσης, καθώς και οδηγίες για το πως θα αναβαθμίσετε από την παλιά σας έκδοση.',
	'VERSION_UP_TO_DATE'		=> 'Η εγκατάστασή σας είναι ενημερωμένη, δεν υπάρχουν ενημερώσεις για την έκδοση του phpBB Garage σας. Αν θέλετε συνεχίστε για έλεγχο των αρχείων.',
	'VERSION_UP_TO_DATE_ACP'	=> 'Η εγκατάστασή σας είναι ενημερωμένη, δεν υπάρχουν ενημερώσεις για την έκδοση του phpBB Garage σας. Δεν χρειάζεται να ενημερώσετε την εγκατάστασή σας.',
));

/**
* Language keys for phpBB Garage auto remover
*/
$lang = array_merge($lang, array(
	'REMOVE_INTRO'			=> 'Καλώς ορίσατε στο πρόγραμμα αφαίρεσης',
	'REMOVE_INTRO_BODY'		=> 'Με αυτή την επιλογή μπορείτε να αφαιρέσετε το phpBB Garage σας.</p>

	<p><strong>Σημείωση:</strong> Αυτό το πρόγραμμα απεγκατάστασης θα απεγκαταστήσει όλο το phpBB Garage. Όταν τα δεδομένα αφαιρεθούν, δεν υπάρχει επιλογή ανάκτησης. Μόνο μια ανάκτηση βάσης και αρχείων από κάποιο αντίγραφο ασφαλείας που δημιουργήθηκε πριν από αυτή την ενέργεια μπορεί να επαναφέρει το phpBB Garage στην πρότερή του κατάσταση. Πατώντας το επόμενο βήμα, η διαδικασία θα ξεκινήσει. ΜΗΝ ΠΡΟΧΩΡΗΣΕΤΕ ΑΝ ΔΕΝ ΕΙΣΤΕ ΑΠΟΛΥΤΑ ΣΙΓΟΥΡΟΙ.</p>

	<p>Το phpBB Garage μετακινεί</p>
	<ul> 
		<li>Όλους τους δημιουργημένους πίνακες</li>
		<li>Όλα τα δεδομένα</li>
		<li>Όλα τα αρχεία του phpBB Garage</li>
		<li>Όλα τα phpBB Garage modules</li>
		<li>Όλα τα δικαιώματα του phpBB Garage</li>
		</ul>',
	'REMOVE_COMPLETE'		=> 'Το phpBB Garage αφαιρέθηκε!!',
	'REMOVE_COMPLETE_EXPLAIN'	=> 'Το phpBB Garage αφαιρέθηκε με επιτυχία!!',
	'INCOMPATIBLE_REMOVE_FILES'	=> 'Τα αρχεία απεγκατάστασης δεν είναι συμβατά με την  έκδοση του προγράμματος εγκατάστασης. Η εγκατεστημένη σας έκδοση είναι η %1$s και τα αρχεία απεγκατάστασης είναι για το phpBB Garage %2$s.',

/**
* Language keys for phpBB Garage UMIL support
*/
	'PHPBB_GARAGE'				=> 'phpBB Garage',
	'PHPBB_GARAGE_EXPLAIN'			=> 'Αυτή η προσθήκη στην phpBB θα επιτρέψει στα μέλη να εισάγουν πληροφορίες σχετικά με τα οχήματα που έχουν.',
	'INSTALL_PHPBB_GARAGE'			=> 'Εγκατάσταση phpBB Garage',
	'INSTALL_PHPBB_GARAGE_CONFIRM'		=> 'Είσαστε έτοιμοι να εγκαταστήσετε το phpBB Garage;',
	'INSERT_REQUIRED_DATA'			=> 'Εισαγωγή απαιτούμενων δεδομένων στους πίνακες του phpBB Garage.',
	'UNINSTALL_PHPBB_GARAGE'		=> 'Απεγκατάσταση του phpBB Garage',
	'UNINSTALL_PHPBB_GARAGE_CONFIRM'	=> 'Είσαστε σίγουροι ότι θέλετε να απεγκαταστήσετε το phpBB Garage;  Όλες οι ρυθμίσεις και τα αποθηκευμένα δεδομένα θα σβηστούν!',
	'UPDATE_PHPBB_GARAGE'			=> 'Ενημέρωση phpBB Garage',
	'UPDATE_PHPBB_GARAGE_CONFIRM'		=> 'Είσαστε σίγουροι ότι θέλετε να ενημερώσετε το phpBB Garage;'	
));

?>
