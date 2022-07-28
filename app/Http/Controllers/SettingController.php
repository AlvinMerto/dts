<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use \DB;

class SettingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function read_json()
    {
    	$file = 'E:\Joules\Documents\Database\emps.txt';
        $content = file($file);
        $array = array();

    	return view('settings.read-json',compact('content'));
    }

    public function incsv() {
        $file = 'E:\Joules\Documents\Database\emps.txt';
        $content = file($file);
        $array = array();

        $json = '[{"f_name":"RICO, JOLITO D","email_2":"jolito.rico@minda.gov.ph","Username":"joules","position_name":"SOFTWARE DEVELOPER"},{"f_name":"TEJANO, RAYMOND R","email_2":"raymond.tejano@minda.gov.ph,rtejano@gmail.com","Username":"rtejano","position_name":"ITO II"},{"f_name":"SULLANO, MARLO D","email_2":"marlo.sullano@minda.gov.ph","Username":"msullano","position_name":"Development Management Officer III"},{"f_name":"RAMOS, ROXENNE G","email_2":"roxenne.gador@minda.gov.ph","Username":"rgador","position_name":"DMO I"},{"f_name":"ESCANO, CHARLITA A","email_2":"charlie.escano@minda.gov.ph, charandalesescano@gmail.com","Username":"cescano","position_name":"Director IV"},{"f_name":"ANCHETA, EDWIN V","email_2":"edwin.ancheta@minda.gov.ph","Username":"eancheta","position_name":"Finance Assistant"},{"f_name":"TAN, REYZALDY B","email_2":"reyzaldy.tan@minda.gov.ph, mikong_rt@yahoo.com","Username":"rtan","position_name":"Director IV"},{"f_name":"BRUCE, LADY LYN A","email_2":"lady.albarico@minda.gov.ph","Username":"lbruce","position_name":"Development Management Officer I"},{"f_name":"DE CASTRO, HELEN ","email_2":"helen.decastro@minda.gov.ph,decastro_h@yahoo.com","Username":"hdecastro","position_name":"Development Management Officer V"},{"f_name":"CASTILLO, ROMMEL S","email_2":"rommel.castillo@minda.gov.ph,rscastle.ph@gmail.com","Username":"rcastillo","position_name":"Chief Administrative Officer"},{"f_name":"PURUGGANAN, HERLYN G","email_2":"neng.gallo@minda.gov.ph,nenggallo74@gmail.com","Username":"hpurugganan","position_name":"Supervising Administrative Officer"},{"f_name":"REYNALDO, GERARDO RAMON CESAR ","email_2":"gerardo.reynaldo@minda.gov.ph,jojo_rsg@yahoo.com","Username":"greynaldo","position_name":"Development Management Officer V"},{"f_name":"SANTIAGO, SHARON D","email_2":"sharon.santiago@minda.gov.ph","Username":"ssantiago","position_name":"Administrative Officer V"},{"f_name":"DAGALA, OLIE B","email_2":"olie.dagala@minda.gov.ph","Username":"odagala","position_name":"Director III"},{"f_name":"CRISTOBAL, JASPER ","email_2":"jasper.cristobal@minda.gov.ph","Username":"jcristobal","position_name":"ISA"},{"f_name":"MATEO, KATHY MAR S","email_2":"kathymar.mateo@minda.gov.ph","Username":"kmateo","position_name":"Development Management Officer IV"},{"f_name":"MONTENEGRO, ROMEO M","email_2":"romeo.montenegro@minda.gov.ph,yomontenegro@yahoo.com","Username":"rmontenegro","position_name":"Deputy Executive Director"},{"f_name":"CAJILIG, EDWIN ","email_2":"edwin.cajilig@minda.gov.ph","Username":"ecajilig","position_name":"Administrative AIDE III"},{"f_name":"YAGO, NINA R","email_2":"nina.yago@minda.gov.ph","Username":"nyago","position_name":"Development Management Officer II"},{"f_name":"CAAGOY, MARICEL L","email_2":"mariz.caagoy@minda.gov.ph","Username":"mcaagoy","position_name":"Administrative Officer I"},{"f_name":"QUIZO, IRIS MAE F","email_2":"iris.ferraris@minda.gov.ph","Username":"iquizo","position_name":"Information officer II"},{"f_name":"CAPULONG, GINA RUTH C","email_2":"ginaruth.capulong@minda.gov.ph","Username":"gcapulong","position_name":"Development Management Officer II"},{"f_name":"PRIETO, FLAVIA C","email_2":"flavia.prieto@minda.gov.ph","Username":"fprieto","position_name":"Administrative AIDE IV"},{"f_name":"SARIGUMBA, MARIVIC ","email_2":"marivic.sarigumba@minda.gov.ph","Username":"msarigumba","position_name":"Administrative Officer IV"},{"f_name":"DUARTE JR., JOSELITO R","email_2":"joselito.duarte@minda.gov.ph","Username":"jduarte","position_name":"Administrative AIDE IV"},{"f_name":"MALNEGRO, GENEROSO T","email_2":"generoso.malnegro@minda.gov.ph","Username":"gmalnegro","position_name":"Administrative AIDE IV"},{"f_name":"LEPARTO, ARGIE S","email_2":"argie.leparto@minda.gov.ph, argie_lee2@yahoo.com","Username":"aleparto","position_name":"Development Management Officer IV"},{"f_name":"BACONGALLO, DIANA S","email_2":"diana.bacongallo@minda.gov.ph","Username":"dbacongallo","position_name":"Development Management Officer II"},{"f_name":"JUALO, MARILYN P","email_2":"marilyn.jualo@minda.gov.ph","Username":"mjualo","position_name":"Executive Assistant III"},{"f_name":"PASAWILAN, MAKMOD S","email_2":"makmod.pasawilan@minda.gov.ph,mspasawilan@gmail.com","Username":"mpasawilan","position_name":"Development Management Officer IV"},{"f_name":"LABOR, ANA MARIE A","email_2":"ana.ayano@minda.gov.ph","Username":"alabor","position_name":"Development Management Officer I"},{"f_name":"GILAYO, EAMARIE ","email_2":"eamarie.gilayo@minda.gov.ph","Username":"egilayo","position_name":"Development Management Officer III"},{"f_name":"CASINTO, MADANIA M","email_2":"madania.malang@minda.gov.ph","Username":"mcasinto","position_name":"Development Management Officer II"},{"f_name":"APURADO, MARJORIE M","email_2":"marjorie.apurado@minda.gov.ph","Username":"mapurado","position_name":"Development Management Officer II"},{"f_name":"BARRERA, JOAN S","email_2":"joan.barrera@minda.gov.ph,pdd.minda@gmail.com","Username":"jbarrera","position_name":"Development Management Officer V"},{"f_name":"VALDERIA, YVETTE G","email_2":"yvette.valderia@minda.gov.ph","Username":"yvalderia","position_name":"Development Management Officer IV"},{"f_name":"CORNITA, RUDISA B","email_2":"odie.cornita@minda.gov.ph","Username":"rcornita","position_name":"Development Management Officer II"},{"f_name":"PINSOY, ROLANDO B","email_2":"rolando.pinsoy@minda.gov.ph","Username":"rpinsoy","position_name":"Development Management Officer III"},{"f_name":"TOMAS JR., ERNESTO M","email_2":"ernie.tomas@minda.gov.ph","Username":"etomas","position_name":"ITO III"},{"f_name":"BINANCILAN, ANELYN G","email_2":"anelyn.binancilan@minda.gov.ph,anelyn2012@gmail.com","Username":"abinancilan","position_name":"Development Management Officer IV"},{"f_name":"GAN, JOHN MAYNARD V","email_2":"johnmaynard.gan@minda.gov.ph","Username":"jgan","position_name":"Development Management Officer III"},{"f_name":"MIRAL, JONATHAN ","email_2":"jon.miral@minda.gov.ph","Username":"jmiral","position_name":"Development Management Officer V"},{"f_name":"SALES, SYLVESTER ","email_2":"sylvester.sales@minda.gov.ph","Username":"ssales","position_name":"Development Management Officer IV"},{"f_name":"CUNANAN, MA. CAMILA LUZ G","email_2":"melot.ginete@minda.gov.ph","Username":"mginete","position_name":"Development Management Officer V"},{"f_name":"DATUKAN, AMHED JEOFFREY ","email_2":"amhed.datukan@minda.gov.ph","Username":"adatukan","position_name":"Development Management Officer III"},{"f_name":"CUELLO, AURORA J","email_2":"aurora.cuello@minda.gov.ph, ajcuello@gmail.com","Username":"acuello","position_name":"Supervising Administrative Officer"},{"f_name":"PONSICA, SAMUEL J","email_2":"samuel.ponsica@minda.gov.ph","Username":"sponsica","position_name":"Graphic Artist"},{"f_name":"FLORES, FRITZ E","email_2":"fritz.flores@minda.gov.ph","Username":"fflores","position_name":"Information Officer III"},{"f_name":"LURA, JEMBER ALLEN P","email_2":"jember.lura@minda.gov.ph","Username":"jlura","position_name":"Administrative AIDE III"},{"f_name":"MAQUILING, KARL SAM M","email_2":"karl.maquiling@minda.gov.ph, karlmaqs@gmail.com","Username":"kmaquiling","position_name":"Development Management Officer II"},{"f_name":"ALMASA, SHEILA B","email_2":"sheilamae.almasa@minda.gov.ph","Username":"salmasa","position_name":"Development Management Officer III"},{"f_name":"BAGUIO, ROSEMARIE ANN O","email_2":"rosemarie.baguio@minda.gov.ph, esorbaguio09231994@gmail.com","Username":"rbaguio","position_name":"Development Management Officer I"},{"f_name":"CEREZO, CARLOS ","email_2":"carlos.cerezo@minda.gov.ph","Username":"ccerezo","position_name":"Development Management Officer III"},{"f_name":"GELDORE, KATHERINE ZENITH L","email_2":"katherine.geldore@minda.gov.ph","Username":"kgeldore","position_name":"Development Management Officer II"},{"f_name":"GOTERA, ANNABELLE R","email_2":"bellerosales.gotera@minda.gov.ph","Username":"agotera","position_name":"Development Management Officer I"},{"f_name":"HERNAEZ, ANITA D","email_2":"nitz.hernaez@minda.gov.ph","Username":"ahernaez","position_name":"Development Management Officer I"},{"f_name":"LORENZANA, LIDDY JANE ","email_2":"liddy.lorenzana@minda.gov.ph","Username":"llorenzana","position_name":"Administrative Assistant"},{"f_name":"MUSA, JIMMY K","email_2":"jimmy.musa@minda.gov.ph, jimmymusa08@gmail.com","Username":"jmusa","position_name":"Development Management Officer III"},{"f_name":"REYES, APRIL ROSE E","email_2":"april.reyes@minda.gov.ph","Username":"areyes","position_name":"Development Management Officer II"},{"f_name":"SOLERA, JODEELYN C","email_2":"joedeelyn.solera@minda.gov.ph","Username":"jsolera","position_name":"Administrative AIDE III"},{"f_name":"TRINO, CECILIA D","email_2":"cecil.trino@minda.gov.ph,cecilc@yahoo.com","Username":"ctrino","position_name":"Chief Administrative Officer"},{"f_name":"UNGAB, MICHELLE MARIE B","email_2":"michelle.ungab@minda.gov.ph","Username":"mungab","position_name":"Development Management Officer I"},{"f_name":"VILLANUEVA, WILLIE C","email_2":"willie.villanueva@minda.gov.ph","Username":"wvillanueva","position_name":"Driver"},{"f_name":"CAMAGONG, MA. CRISTINA S","email_2":"kit.camagong@minda.gov.ph","Username":"mcamagong","position_name":"Administrative Officer III"},{"f_name":"AGUAVIVA, RACHAEL ","email_2":"rachael.aguaviva@minda.gov.ph","Username":"raguaviva","position_name":"Development Management Officer II"},{"f_name":"ESPERAT, RAYMOND PETER D","email_2":"raymond.esperat@minda.gov.ph","Username":"resperat","position_name":"Development Management Officer III"},{"f_name":"BARRIOS, MERCY B","email_2":"mercy.barrios@minda.gov.ph","Username":"mbarrios","position_name":"Development Management Officer II"},{"f_name":"ABRIL, RUEL P","email_2":"ruel.abril@minda.gov.ph","Username":"rabril","position_name":"DMO I"},{"f_name":"TOLENTINO, JEAN PAUL ","email_2":"jeanpaul.tolentino@minda.gov.ph","Username":"jtolentino","position_name":"Development Management Officer I"},{"f_name":"VISITACION, ROGELIO ","email_2":"rogelio.visitacion@minda.gov.ph","Username":"rvisitacion","position_name":"Development Management Officer III"},{"f_name":"VERZOSA, MARY ANN ","email_2":"maryann.verzosa@minda.gov.ph","Username":"mverzosa","position_name":"Administrative Officer II\/HRMO I"},{"f_name":"PINES, SHARLYN JOY T","email_2":"sharlyn.pines@minda.gov.ph,sharlynjoypines@gmail.com","Username":"spines","position_name":"Finance Assistant"},{"f_name":"VILLABRILLE, AMY C","email_2":" ","Username":"avillabrille","position_name":"Utility"},{"f_name":"SINOGBUHAN, MICHAEL A","email_2":" ","Username":"msinogbuhan","position_name":"Security"},{"f_name":"GARACHO, CARLOS ","email_2":"kathleen.bahinting@minda.gov.ph","Username":"cgaracho","position_name":"Utility"},{"f_name":"LUNGAY, CESAR P","email_2":" ","Username":"clungay","position_name":"Security"},{"f_name":"TAGAB, LUZEDELIO ","email_2":" ","Username":"ltagab","position_name":"Utility"},{"f_name":"ASNA, ELESIO N","email_2":" ","Username":"easna","position_name":"Security"},{"f_name":"UNGGUI, ARMAN A","email_2":" ","Username":"aunggui","position_name":"Security"},{"f_name":"ALONTO, HONEY JADE V","email_2":"honeyjade.alonto@minda.gov.ph","Username":"halonto","position_name":"Administrative Officer V"},{"f_name":"ARNOCO, IVY MAE G","email_2":"ivymae.arnoco@minda.gov.ph, ivymaearnoco@yahoo.com","Username":"iarnoco","position_name":"Development Management Officer I"},{"f_name":"LAGAHIT, NEMESIO JR. D","email_2":" ","Username":"nlagahit","position_name":"Utility"},{"f_name":"IBANEZ, JESSA A","email_2":"kathleen.bahinting@minda.gov.ph","Username":"jibanez","position_name":"Security"},{"f_name":"ACOSTA, VIGILIO JR M","email_2":"virgilio.acosta@minda.gov.ph","Username":"vacosta","position_name":"Administrative Assistant"},{"f_name":"BUSTAMANTE, JOHN MICHAEL T","email_2":"johnmichael.bustamante@minda.gov.ph","Username":"jbustamante","position_name":"Administrative Aide"},{"f_name":"BONDOC, ALLAN DOMINIC C","email_2":"adcbondoc@gmail.com","Username":"abondoc","position_name":"Admin Specialist"},{"f_name":"TORRECAMPO, NEIL S","email_2":"neil.torrecampo@minda.gov.ph","Username":"ntorrecampo","position_name":"Administrative Aide"},{"f_name":"TANCIO, DAHLIA MONICA D","email_2":"dahliamonica.tancio@minda.gov.ph","Username":"dtancio","position_name":"Accountant III"},{"f_name":"BUHAT JR., RENATO ","email_2":"renato.buhat@minda.gov.ph","Username":"rbuhat","position_name":"Development Management Officer III"},{"f_name":"DAANOY, ARCHIE D","email_2":"archie.daanoy@minda.gov.ph","Username":"adaanoy","position_name":"Driver"},{"f_name":"PIONG, IRENEO JR S","email_2":"ireneo.piong@minda.gov.ph","Username":"ipiong","position_name":"Development Management Officer III"},{"f_name":"RUIZ, JERRY A","email_2":"jerry.ruiz@minda.gov.ph","Username":"jruiz","position_name":"Driver"},{"f_name":"MONDIDO, RICHIE MARK T","email_2":"richie.mondido@minda.gov.ph","Username":"rmondido","position_name":"Information Systems Researcher II"},{"f_name":"MERTO, ALVIN JAY B","email_2":"alvinjay.merto@minda.gov.ph","Username":"amerto","position_name":"Software Programmer"},{"f_name":"NIEVE, CAMERON B","email_2":"cameron.nieve@minda.gov.ph","Username":"cnieve","position_name":"Software Programmer"},{"f_name":"QUIBOD, KRISTINE MAE M","email_2":"kristinemae.quibod@minda.gov.ph,tinquibod.addulaw@gmail.com","Username":"kquibod","position_name":"Attorney IV"},{"f_name":"DEMARUNSING, MASRON C","email_2":"masron.demarunsing@minda.gov.ph, masron.demarunsingll@gmail>com","Username":"mdemarunsing","position_name":"Administrative Assistant"},{"f_name":"CODAL, IRISH J","email_2":"irish.codal@minda.gov.ph","Username":"icodal","position_name":"Administrative Assistant"},{"f_name":"MABALE, WILSON D","email_2":"wilson.mabale@minda.gov.ph","Username":"wmabale","position_name":"DMO II"},{"f_name":"ENJAMBRE, LORDILIE S","email_2":"lordilie.enjambre@minda.gov.ph,lords.enjambre@gmail.com","Username":"lenjambre","position_name":"Development Management Officer III"},{"f_name":"LAWANSA, EMELIAN L","email_2":"emelian.lawansa@minda.gov.ph, emeledlaw@gmail.com","Username":"elawansa","position_name":"Development Management Officer V"},{"f_name":"UMNGAN, ABDUL-JALIL S","email_2":"jal.umngan@minda.gov.ph","Username":"aumngan","position_name":"Development Management Officer V"},{"f_name":"DAMASO, KATHREEN MAE E","email_2":" ","Username":"kdamaso","position_name":"COA"},{"f_name":"MARBAS, SUNDEE F","email_2":"sundee.marbas@minda.gov.ph","Username":"smarbas","position_name":"Planning Officer III"},{"f_name":"SULTAN, AMINAH O","email_2":"aminah.sultan@minda.gov.ph","Username":"asultan","position_name":"DMO I"},{"f_name":"LOPOZ, CESO I, USEC. JANET M","email_2":"janet.lopoz@minda.gov.ph,janetmlopoz@yahoo.com","Username":"jlopoz","position_name":"Executive Director"},{"f_name":"CASAN, INDERAH M","email_2":"inderah.casan@minda.gov.ph","Username":"icasan","position_name":"Administrative Assistant"},{"f_name":"TAMAYO, ADRIAN M","email_2":"adrian.tamayo@minda.gov.ph","Username":"atamayo","position_name":"Development Management Officer V"},{"f_name":"TAPANAN, MERLY C","email_2":"merlytapanan@ymail.com","Username":"mtapanan","position_name":"Administrative Assistant"},{"f_name":"ABDULHAMID, MAJID S","email_2":"carlos.cerezo@minda.gov.ph","Username":"mabdulhamid","position_name":"Driver"},{"f_name":"ESTEVA, JEZA MIE B","email_2":"jezamie.esteva@minda.gov.ph","Username":"jesteva","position_name":"Administrative Assistant"},{"f_name":"LUNA, ROTESSA JOYCE A","email_2":"rotessa.luna@minda.gov.ph","Username":"rluna","position_name":"Administrative Assistant"},{"f_name":"DUCAY, RICHARD C","email_2":" richard.ducay@minda.gov.ph","Username":"rducay","position_name":"Administrative Assistant"},{"f_name":"TABLA, LOYGIE H","email_2":"loygie.tabla@minda.gov.ph","Username":"ltabla","position_name":"Administrative Assistant"},{"f_name":"DATUKON, RANIZZA D","email_2":" ranizza.datukon@minda.gov.ph","Username":"rdatukon","position_name":"Attorney III"},{"f_name":"DOLDOLIA, JAMES E","email_2":"james.doldolia@minda.gov.ph","Username":"jdoldolia","position_name":"Technical Staff"},{"f_name":"MALLI, EDWIN M","email_2":"kathleen.bahinting@minda.gov.ph","Username":"emalli","position_name":"Security &n Peace and Order Officer"},{"f_name":"GUMATAS, GERALD V","email_2":"kathleen.bahinting@minda.gov.ph","Username":"ggumatas","position_name":"Technical Staff"},{"f_name":"ESTAMPADOR, JOHNYLYN C","email_2":"kathleen.bahinting@minda.gov.ph","Username":"jestampador","position_name":"Administrative Assistant"},{"f_name":"POLANCOS, PERICLES G","email_2":"kathleen.bahinting@minda.gov.ph","Username":"ppolancos","position_name":"Administrative Assistant"},{"f_name":"ANTIPATIA, NARENO C","email_2":"kathleen.bahinting@minda.gov.ph","Username":"nantipatia","position_name":"Technical Staff"},{"f_name":"DE ASIS, GINA T","email_2":"kathleen.bahinting@minda.gov.ph","Username":"gdeasis","position_name":"Administrative Aide"},{"f_name":"CALOTES, JEAN T","email_2":"kathleen.bahinting@minda.gov.ph","Username":"jcalotes","position_name":"Technical Staff"},{"f_name":"TUDLAS, MAYETTE S","email_2":" ","Username":"mtudlas","position_name":"Executive Assistant IV"},{"f_name":"BILLONES, CLAIRE ROSE ANN D","email_2":"kathleen.bahinting@minda.gov.ph","Username":"cbillones","position_name":"Technical Staff"},{"f_name":"ESTAMPADOR, RODERICK C","email_2":"kathleen.bahinting@minda.gov.ph","Username":"restampador","position_name":"Administrative Assistant"},{"f_name":"BANGCAYA, GENEVIEVE A","email_2":"meriam.eumenda@minda.gov.ph","Username":"gbangcaya","position_name":"Technical Staff"},{"f_name":"PENALOZA, REX M","email_2":"kathleen.bahinting@minda.gov.ph","Username":"rpenaloza","position_name":"Admin Specialist"},{"f_name":"BAHINTING, KATLEEN FRACHESCA L","email_2":"kathleen.bahinting@minda.gov.ph","Username":"kbahinting","position_name":"Technical Staff"},{"f_name":"DAPUDONG, EDRIN P","email_2":"kathleen.bahinting@minda.gov.ph","Username":"edapudong","position_name":"Admin Specialist"},{"f_name":"SOLIN, FRANCISCO C","email_2":" ","Username":"fsolin","position_name":"Administrative Aide V"},{"f_name":"PARILLO, ROSELYN P","email_2":" ","Username":"rparillo","position_name":"Executive Assistant V"},{"f_name":"GARCIA, JOHN CARLO S","email_2":"kathleen.bahinting@minda.gov.ph","Username":"jgarcia","position_name":"Admin Specialist"},{"f_name":"PENAS JR., ROMEO S","email_2":"kathleen.bahinting@minda.gov.ph","Username":"rpenas","position_name":"Admin Specialist"},{"f_name":"HADJIRIL, BINANG A","email_2":"binang.hadjiril@minda.gov.ph","Username":"bhadjiril","position_name":"Security &n Peace and Order Officer"},{"f_name":"BACARO, JOY A","email_2":" ","Username":"jellaga","position_name":"Utility"},{"f_name":"AMPON, AVELINO L","email_2":" ","Username":"ampon","position_name":"Utility"},{"f_name":"ALERTA, ELLENE B","email_2":"ellene.alerta@minda.gov.ph","Username":"ealerta","position_name":"Technical Staff"},{"f_name":"MAYORMITA JR, GEORGE A","email_2":" ","Username":"gmayormita","position_name":"Security"},{"f_name":"VITASOLO, CHRISTOPHER A","email_2":" ","Username":"cvitasolo","position_name":"Security"},{"f_name":"SARINO, KIMBERLY JOY D","email_2":"kathleen.bahinting@minda.gov.ph","Username":"ksarino","position_name":"Admin Specialist"},{"f_name":"OLASIMAN, TERRY R","email_2":"terry.olasiman@minda.gov.ph","Username":"tolasiman","position_name":"Admin Specialist"},{"f_name":"FUENTES, LEA V","email_2":"lea.fuentes@minda.gov.ph","Username":"lfuentes","position_name":"Admin Specialist"},{"f_name":"TUPAS, JOYCE O","email_2":"kathleen.bahinting@minda.gov.ph","Username":"jtupas","position_name":"Admin Specialist"},{"f_name":"VILLORENTE, PETER PAUL C","email_2":"peterpaul.villorente@minda.gov.ph","Username":"pvillorente","position_name":"Admin Specialist"},{"f_name":"MAGHOPOY, GLYDSI FEDERICO C","email_2":"glysdi.maghopoy@minda.gov.ph","Username":"gmaghopoy","position_name":"Finance Assistant"},{"f_name":"MANONGDO, RALPH R","email_2":"ralph.manongdo@minda.gov.ph","Username":"rmanongdo","position_name":"Technical Staff"},{"f_name":"RESIMILLA, EDGAR B","email_2":" ","Username":"eresimilla","position_name":"Security"},{"f_name":"REMEGIO, PAUL A","email_2":" ","Username":"premegio","position_name":"Security"},{"f_name":"SOLIS, FERNANDO ANECITO T","email_2":" ","Username":"fanecito","position_name":"Executive Assistant II"},{"f_name":"FERNANDEZ, WYNCELL L","email_2":"wyncell.fernandez@minda.gov.ph","Username":"wfernandez","position_name":"Admin Specialist"},{"f_name":"CABILOGAN, ROMMEL C","email_2":"rommel.cabilogan@minda.gov.ph","Username":"rcabilogan","position_name":"Administrative AIDE IV"},{"f_name":"FERRER, HANNAH MARIE G","email_2":"hannah.ferrer@minda.gov.ph","Username":"hferrer","position_name":"Admin Specialist"},{"f_name":"AMEEN, ABDULHAKIM D","email_2":" ","Username":"aameen","position_name":"COA Team Leader"},{"f_name":"BOTENES, REGINE S","email_2":"regine.botenes@minda.gov.ph","Username":"rbotenes","position_name":"Administrative Assistant"},{"f_name":"EUMINDA, MERIAM P","email_2":"meriam.eumenda@minda.gov.ph","Username":"meuminda","position_name":"Administrative Assistant"},{"f_name":"NAVALES, CHESTOM MARK A","email_2":"cheston.navales@minda.gov.ph","Username":"cnavales","position_name":"Social Media Content Editor"},{"f_name":"FAJARDO, STEPHEN JUNE A","email_2":"stephen.fajardo@minda.gov.ph","Username":"sfajardo","position_name":"Media Expert"},{"f_name":"LABRADOR, ANGELOU S","email_2":"angelou.labrador@minda.gov.ph","Username":"alabrador","position_name":"Admin Specialist"},{"f_name":"SALDIVAR, SAMUEL D","email_2":"samuel.saldivar@minda.gov.ph","Username":"ssaldivar","position_name":"Social Media Content Editor"},{"f_name":"TROZO, PREXX MARNIE KATE M","email_2":"prexx.trozo@minda.gov.ph","Username":"ptrozo","position_name":"Technical Assistant"},{"f_name":"AMPONG, AGUILARDO A","email_2":"wilson.mabale@minda.gov.ph","Username":"aguilardo","position_name":"Utility"},{"f_name":"CABERTE, SOLIVER D","email_2":"ireneo.piong@minda.gov.ph","Username":"scaberte","position_name":"Utility"},{"f_name":"ASSIN, LYKA JOY A","email_2":"carlos.cerezo@minda.gov.ph","Username":"lassin","position_name":"Utility"},{"f_name":"GEROCHE, JEIMAR T","email_2":" ","Username":"jgeroche","position_name":"Security"},{"f_name":"RICO, JOLITO D","email_2":"jolito.rico@minda.gov.ph","Username":"jrico","position_name":"Software Programmer"},{"f_name":"AGOR, RALPH LAURENCE A","email_2":"ralphlaurence.agor@minda.gov.ph","Username":"ragor","position_name":"Software Programmer"},{"f_name":"JAVIER, BENEDICTO A","email_2":"benedicto.javier@minda.gov.ph","Username":"bjavier","position_name":"Admin Specialist"},{"f_name":"QUINTERO, LALAINE F","email_2":"lalaine.quintero@minda.gov.ph","Username":"lquintero","position_name":"Administrative Assistant"},{"f_name":"ASDILLO, RANDY P","email_2":" ","Username":"rasdillo","position_name":"Driver"},{"f_name":"RECIMILLA, JOEY E","email_2":"joey.recimilla@minda.gov.ph","Username":"jrecimilla","position_name":"Director III"},{"f_name":"LEGASPI, OLIVER V","email_2":"oliver.legaspi@minda.gov.ph","Username":"olegaspi","position_name":"Administrative\/Technical Staff"},{"f_name":"AKBAR, CHERRYLYN S","email_2":" ","Username":"cakbar","position_name":"ASEC"},{"f_name":"VALERIO, SOCRATES M","email_2":"socvalerz@gmail.com","Username":"svalerio","position_name":"Administrative\/Technical Staff"},{"f_name":"TADENA, FELIPE C","email_2":" ","Username":"ftadena","position_name":"Utility"}]';

			//dd($content);

        $array2 = json_decode($json, true);

        foreach ($array2 as $arr) {
        	# code...
        	echo $arr['f_name'].' = '. $arr['email_2'].'<br/>';

        	$data = DB::insert('insert into users (name, f_name, email, password, position) values (?, ?, ?, ?, ?)', 
                [
                 	$arr['Username'],
                	$arr['f_name'],
                	$arr['email_2'],
                	'$2y$10$Uq1OLAxMeTPknXLUwK0ZH.D9ZwoxotGcW65UPEjLuMZIDPMi3lrqO',
                	$arr['position_name'],
            ]);

        }
        
        //f_name":"TEJANO, RAYMOND R","email_2":"raymond.tejano@minda.gov.ph,rtejano@gmail.com","Username":"rtejano","position_name":"ITO II"
	}

    public function change_credentials($id){

        $data = DB::table('users')
                    ->where(['users.name'=>$id])
                    ->get();

        return view('settings.change_password_data',compact('data'));
    }

    public function update_credential(Request $request,$newpass){

        if(request()->ajax())
        {
            $data = DB::table('users')
                    ->where(['users.name'=>$newpass])
                    ->update([
                        'password'=>Hash::make($request->get('newpassword')),
                    ]);

            Auth::logout();
            Session::flash('success',"logout");
            //return redirect()->route('login');
            return response()->JSON(['data' => $data]); 
        }
    }

    public function view_profile($id)
    {
        $data = DB::table('users')
                    ->where(['users.id'=>$id])
                    ->get();

        return view('settings.profile-view',compact('data'));
    }

    public function update_profile($id)
    {
        $data = DB::table('users')
                    ->where(['users.id'=>$id])
                    ->get();

        return view('settings.profile-update',compact('data'));
    }

    public function save_profile_data(Request $request, $id)
    {
        if(request()->ajax())
        {
            $data = DB::table('users')
                    ->where(['users.id'=>$id])
                    ->update([
                        'name'      =>   $request->get('uname'),
                        'f_name'    =>   strtoupper($request->get('fname')),
                        'email'     =>   $request->get('email'),

                    ]);
            return response()->JSON(['data' => $data]);
        }
    }

    public function upload_image(Request $request,$id)
    {
        if($request->hasFile('img_file')) {
            $filenameWithExt = $request->file('img_file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);            
            $extension = $request->file('img_file')->getClientOriginalExtension();
            $fileNameToStore = time().'_'.$filename.'.'.$extension;                       

            $file = $request->file('img_file');
            $file->getClientOriginalName();
            $encryp = md5($file);
            $destinationPath = 'public/dist/profile';
            $file->move($destinationPath,$encryp.'.'.$extension);

        } else {
            $encryp='NoImage';
            $extension='png';
        }

        $data = DB::table('users')
                ->where(['users.id'=>$id])
                ->update([
                    'profile_img' => $encryp.'.'.$extension,
                ]);

        return redirect('/setting/my-account/'.Auth::user()->id);
    }
}
